<?php

class resize {

        //variaveis da classe
        private $image;
        private $width;
        private $height;
        private $imageResized;

        function __construct($fileName) {
            //abre o arquivo
            $this->image = $this->openImage($fileName);

            //pega a largura e altura do arquivo
            $this->width = imagesx($this->image);
            $this->height = imagesy($this->image);
        }

        private function openImage($file) {
            //pega a extensão
            $extension = strtolower(strrchr($file, '.'));

            switch ($extension) {
                case '.jpg':
                case '.jpeg':
                    $img = @imagecreatefromjpeg($file);
                    break;
                case '.gif':
                    $img = @imagecreatefromgif($file);
                    break;
                case '.png':
                    $img = @imagecreatefrompng($file);
                    break;
                default:
                    $img = false;
                    break;
            }
            return $img;
        }

        public function resizeImage($newWidth, $newHeight, $option = "auto") {
            //Obtenha largura e altura ideais - com base em $option
            $optionArray = $this->getDimensions($newWidth, $newHeight, $option);

            $optimalWidth = $optionArray['optimalWidth'];
            $optimalHeight = $optionArray['optimalHeight'];


            //Resample - Criar uma tela de imagem de x, y tamanho
            $this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
            imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);


            //Se a opcão for 'crop', então crop de novo
            if ($option == 'crop') {
                $this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
            }
        }

        private function getDimensions($newWidth, $newHeight, $option) {

            switch ($option) {
                case 'exact':
                    $optimalWidth = $newWidth;
                    $optimalHeight = $newHeight;
                    break;
                case 'portrait':
                    $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                    $optimalHeight = $newHeight;
                    break;
                case 'landscape':
                    $optimalWidth = $newWidth;
                    $optimalHeight = $this->getSizeByFixedWidth($newWidth);
                    break;
                case 'auto':
                    $optionArray = $this->getSizeByAuto($newWidth, $newHeight);
                    $optimalWidth = $optionArray['optimalWidth'];
                    $optimalHeight = $optionArray['optimalHeight'];
                    break;
                case 'crop':
                    $optionArray = $this->getOptimalCrop($newWidth, $newHeight);
                    $optimalWidth = $optionArray['optimalWidth'];
                    $optimalHeight = $optionArray['optimalHeight'];
                    break;
            }
            return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
        }

        private function getSizeByFixedHeight($newHeight) {
            $ratio = $this->width / $this->height;
            $newWidth = $newHeight * $ratio;
            return $newWidth;
        }

        private function getSizeByFixedWidth($newWidth) {
            $ratio = $this->height / $this->width;
            $newHeight = $newWidth * $ratio;
            return $newHeight;
        }

        private function getSizeByAuto($newWidth, $newHeight) {
            if ($this->height < $this->width) {
            //A imagem a ser redimensionada é mais larga (paisagem)
                $optimalWidth = $newWidth;
                $optimalHeight = $this->getSizeByFixedWidth($newWidth);
            } elseif ($this->height > $this->width) {
            //A imagem a ser redimensionada é mais alta (retrato)
                $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                $optimalHeight = $newHeight;
            } else {
            //A imagem a ser redimensionada é um quadrado
                if ($newHeight < $newWidth) {
                    $optimalWidth = $newWidth;
                    $optimalHeight = $this->getSizeByFixedWidth($newWidth);
                } else if ($newHeight > $newWidth) {
                    $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                    $optimalHeight = $newHeight;
                } else {
                    $optimalWidth = $newWidth;
                    $optimalHeight = $newHeight;
                }
            }

            return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
        }

        private function getOptimalCrop($newWidth, $newHeight) {

            $heightRatio = $this->height / $newHeight;
            $widthRatio = $this->width / $newWidth;

            if ($heightRatio < $widthRatio) {
                $optimalRatio = $heightRatio;
            } else {
                $optimalRatio = $widthRatio;
            }

            $optimalHeight = $this->height / $optimalRatio;
            $optimalWidth = $this->width / $optimalRatio;

            return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
        }

        private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight) {
            //Acha o centro - Vai ser usado pelo crop
            $cropStartX = ( $optimalWidth / 2) - ( $newWidth / 2 );
            $cropStartY = ( $optimalHeight / 2) - ( $newHeight / 2 );

            $crop = $this->imageResized;
            //A imagem vai cortar para o tamanho expecificado
            $this->imageResized = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($this->imageResized, $crop, 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight, $newWidth, $newHeight);
        }

        public function saveImage($savePath, $imageQuality = "100") {
            //pegar a extensão
            $extension = strrchr($savePath, '.');
            $extension = strtolower($extension);

            switch ($extension) {
                case '.jpg':
                case '.jpeg':
                    if (imagetypes() & IMG_JPG) {
                        imagejpeg($this->imageResized, $savePath, $imageQuality);
                    }
                    break;

                case '.gif':
                    if (imagetypes() & IMG_GIF) {
                        imagegif($this->imageResized, $savePath);
                    }
                    break;

                case '.png':
                    //Aumentar a qualidade de 0-100 para 0-9
                    $scaleQuality = round(($imageQuality / 100) * 9);

                    //Inverter configuração de qualidade como 0 é melhor, não 9
                    $invertScaleQuality = 9 - $scaleQuality;

                    if (imagetypes() & IMG_PNG) {
                        imagepng($this->imageResized, $savePath, $invertScaleQuality);
                    }
                    break;
                default:
                    //Se não tiver uma extensão, não vai salvar
                    break;
            }
            imagedestroy($this->imageResized);
        }
    }
    