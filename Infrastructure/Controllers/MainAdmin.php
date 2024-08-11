<?php

namespace Aljerom\Solnushkov\Infrastructure\Controllers;

use MagicPro\Application\Controller;
use MagicPro\Config\Config;
use MagicPro\Contracts\Database\DatabaseInterface;
use MagicPro\DDD\Repository\CycleORM\BulkOperationsTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MainAdmin extends Controller
{
    use BulkOperationsTrait;

    public function actionIndex(ServerRequestInterface $request): ResponseInterface
    {
        return $this->render('index');
    }

    public function actionRestorePass(ServerRequestInterface $request): ResponseInterface
    {
        return $this->render('restorePass');
    }

    public function actionConvert(
        ServerRequestInterface $request,
        DatabaseInterface   $database
    ): ResponseInterface {
        $lentaId = 86;
        $lentaPath = Config::get('dynalenta')['path'];
        $p = 1;
        $bunchSize = 100;
        $sql = ' select ph.* from gal__photos as ph where ph.isUserPhoto > 0 limit ?, ?';
        while (($statement = $database->query($sql, [($p - 1) * $bunchSize, $bunchSize])) && $statement->rowCount()) {
            $data = [];
            $result = $statement->fetchAll();
            foreach ($result as $item) {
                $fileName = ROOT_DIR . $item['path'];
                if (is_file($fileName)) {
                    $upDirFile = $lentaPath . '/' . $lentaId . date('/Y/m/W/');
                    if (!is_dir(ROOT_DIR . $upDirFile)) {
                        mkdir(ROOT_DIR . $upDirFile, 0777, true);
                    }
                    $ext = substr($fileName, strrpos($fileName, '.'));
                    $nameFile = ROOT_DIR . $upDirFile . md5(microtime()) . $ext;
                    if (copy($fileName, $nameFile)) {
                        $filePic = json_encode(
                            [
                                'source' => '',
                                'title' => $item['name'],
                                'path' => str_replace(ROOT_DIR, '', $nameFile)
                            ],
                            JSON_THROW_ON_ERROR
                        );
                    }
                }
                $data[] = [
                    'npp' => $item['npp'],
                    'author' => $item['author'],
                    'dateCreate' => $item['dateCreate'],
                    'datePublication' => $item['dateUpdate'],
                    'text' => $item['comment'],
                    'file_pic' => $filePic ?? '',
                ];
            }
            $operationData = $this->insertOrUpdate(array_keys($data[0]), $data, 'lenta__cat_86');
            $database->execute($operationData->sql, $operationData->bindings);
            $p++;
        }

        return $this->response;
    }
}
