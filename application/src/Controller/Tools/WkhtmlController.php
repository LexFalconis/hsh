<?php

namespace src\Controller\Tools;

use Imagick;
use Knp\Snappy\Image;

/**
 * Class WkhtmlController
 * Fonte de estudos:
 *      https://blog.schoolofnet.com/gerando-pdf-com-snappy/
 *      https://ourcodeworld.com/articles/read/251/how-to-create-a-screenshot-of-a-website-using-knpsnappybundle-wkhtmltoimage-in-symfony-3
 */
class WkhtmlController
{
    /**
     * @param string $url URL do site com http{s}://
     * @param string $filename nome que será dado ao arquivo de imagem
     * @param string $pathToSave caminho onde será salva a imagem
     * @return bool|void
     */
    public function urlToImage(
        string $url,
        string $filename,
        string $pathToSave = SCREENSHOTS_PATH,
    ) {
        try {
            exec("find $pathToSave -type f -exec chmod 0755 {} +");
            $imageWidth = 928;
            $imageHeight = 696;
            $imageExtension = 'jpg';
            $fileWithPath = $pathToSave . "$filename." . $imageExtension;

            $snappy = new Image('/usr/bin/wkhtmltoimage', ['format' => $imageExtension]);
            $snappy
                ->setDefaultExtension($imageExtension)
                ->setOption('width', $imageWidth)
                ->setOption('height', $imageHeight)
            ;

            $tempFile = md5(uniqid());
            if (file_exists($fileWithPath)) {
                rename($fileWithPath, "/tmp/" . $tempFile . "." . $imageExtension);
            }

            $snappy->generate($url, $fileWithPath);

            $imagick = new Imagick();
            $imagick->readImage($fileWithPath);
            $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
            $imagick->setImageCompressionQuality(100);
            $imagick->setImageFormat($imageExtension);
            $imagick->stripImage();
            $imagick->writeImage($fileWithPath);
            $imagick->destroy();

            return true;
        } catch (\Exception $e) {
            rename("/tmp/" . $tempFile . "." . $imageExtension, $fileWithPath);
            $_SESSION['mensagem'] = 'Ocorreu um erro ao tentar salvar o thumbnail do site' . $e->getMessage();
            header("Location:/genericError");
        }
    }

    /**
     * Recupera o path no padrão que é usado no src do html
     * @param $id
     * @return array|string|string[]|null
     */
    public function getImagePathById($id)
    {
        $fileWithPath = SCREENSHOTS_PATH . "$id.jpg";

        if (file_exists($fileWithPath)) {
            return str_replace(
                '/var/www/html/public',
                '',
                $fileWithPath
            );
        }

        return null;
    }

    /**
     * Deleta uma imagem com base em um id
     * @param $id
     * @return bool|void
     */
    public function removeImageById($id)
    {
        try {
            unlink(SCREENSHOTS_PATH . "$id.jpg");
            return true;
        } catch (\Exception $e) {
            $_SESSION['mensagem'] = 'Ocorreu um erro ao tentar salvar o thumbnail do site' . $e->getMessage();
            header("Location:/genericError");
        }
    }
}
