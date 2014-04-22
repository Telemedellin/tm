<?php
/**
 * Backend controller for GalleryManager widget.
 * Provides following features:
 *  - Image removal
 *  - Image upload/Multiple upload
 *  - Arrange images in gallery
 *  - Changing name/description associated with image
 *
 * @author Bogdan Savluk <savluk.bogdan@gmail.com>
 */

class GalleryController extends CController
{
    /** @var string Extensions for gallery images */
    public $galleryExt = 'jpg';
    /** @var string directory in web root for galleries */
    public $galleryDir = 'images/galeria';

    public function filters()
    {
        return array(
            'postOnly + delete, ajaxUpload, order, changeData',
        );
    }

    public function behaviors()
    {
        return array(
            'utilities'=>array(
                'class'=>'application.components.behaviors.Utilities'
            )
        );
    }

    /**
     * Removes image with ids specified in post request.
     * On success returns 'OK'
     */
    public function actionDelete()
    {
        $id = $_POST['id'];
        /** @var $photos GalleryPhoto[] */
        $photos = Foto::model()->with('albumFoto')->findAllByPk($id);
        foreach ($photos as $photo) {
            if ($photo !== null) {
                $base = Yii::getPathOfAlias('webroot') . '/' . $this->galleryDir . '/';
                if (file_exists($base . $photo->albumFoto->directorio . $photo->src))
                    @unlink($base . $photo->albumFoto->directorio . $photo->src);
                if (file_exists($base . $photo->albumFoto->directorio . $photo->thumb))
                    @unlink($base . $photo->albumFoto->directorio . $photo->thumb);
                $photo->delete();
                $url = URL::model()->findByPk($photo->url_id);
                $url->delete();
            }
            else throw new CHttpException(400, 'Photo, not found');
        }
        echo 'OK';
    }

    /**
     * Method to handle file upload thought XHR2
     * On success returns JSON object with image info.
     * @param $album_foto_id string Gallery Id to upload images
     * @throws CHttpException
     */
    public function actionAjaxUpload($album_foto_id = null)
    {
        $album_foto = AlbumFoto::model()->findByPk($album_foto_id);

        $imageFile = CUploadedFile::getInstanceByName('image');
        $time = time() + rand();
        
        $base = Yii::getPathOfAlias('webroot') . '/' . $this->galleryDir . '/' . $album_foto->directorio;
        $src =   $time . '.' . $this->galleryExt;
        $thumb = $time . '_thumb.' . $this->galleryExt;
        
        $image = new Image($imageFile->getTempName());
        $image->save($base . $src);
        $image_thumb  = new Image($imageFile->getTempName());
        $image_thumb->resize(300, null);
        $image_thumb->save($base . $thumb);
        //Yii::app()->image->load($imageFile->getTempName())->save($src);
        //Yii::app()->image->load($imageFile->getTempName())->resize(300, null)->save($thumb);

        $model = new Foto();
        $model->album_foto_id = $album_foto_id;        
        $url = new Url;
        $slug = '#imagenes/'.$this->slugger($album_foto->nombre).'/'.$this->slugger($time);
        $slug = $this->verificarSlug($slug);
        $url->slug      = $slug;
        $url->tipo_id   = 6; //Foto
        $url->estado    = 1;
        $url->save();
        $model->url_id = $url->getPrimaryKey();
        $model->src = $src;
        $model->thumb = $thumb;
        $model->nombre = $time;
        $model->descripcion = '';
        $model->ancho = $image->width;
        $model->alto = $image->height;
        $model->orden = 0;
        $model->estado = 1;
        $model->destacado = 0;
        $model->save();
        
        header("Content-Type: application/json");
        echo CJSON::encode(
            array(
                'id' => $model->id,
                'rank' => $model->orden,
                'name' => (string)$model->nombre,
                'description' => (string)$model->descripcion,
                'preview' => bu($this->galleryDir . '/' . $album_foto->directorio . $thumb ),
            ));
    }

    /**
     * Saves images order according to request.
     * Variable $_POST['order'] - new arrange of image ids, to be saved
     * @throws CHttpException
     */
    public function actionOrder()
    {
        if (!isset($_POST['order'])) throw new CHttpException(400, 'No data, to save');
        $gp = $_POST['order'];
        $orders = array();
        $i = 0;
        foreach ($gp as $k => $v) {
            if (!$v) $gp[$k] = $k;
            $orders[] = $gp[$k];
            $i++;
        }
        sort($orders);
        $i = 0;
        $res = array();
        foreach ($gp as $k => $v) {
            /** @var $p GalleryPhoto */
            $p = Foto::model()->findByPk($k);
            $p->orden = $orders[$i];
            $res[$k]=$orders[$i];
            $p->save(false);
            $i++;
        }

        echo CJSON::encode($res);

    }

    /**
     * Method to update images name/description via AJAX.
     * On success returns JSON array od objects with new image info.
     * @throws CHttpException
     */
    public function actionChangeData()
    {
        if (!isset($_POST['photo'])) throw new CHttpException(400, 'Nothing, to save');
        $data = $_POST['photo'];
        $criteria = new CDbCriteria();
        $criteria->index = 'id';
        $criteria->addInCondition('id', array_keys($data));
        /** @var $models GalleryPhoto[] */
        $models = Foto::model()->findAll($criteria);
        foreach ($data as $id => $attributes) {
            if (isset($attributes['name']))
                $models[$id]->nombre = $attributes['name'];
            if (isset($attributes['description']))
                $models[$id]->descripcion = $attributes['description'];
            $models[$id]->save();
        }
        $resp = array();
        foreach ($models as $model) {
            $af = AlbumFoto::model()->findByPk($model->album_foto_id);
            $resp[] = array(
                'id' => $model->id,
                'rank' => $model->orden,
                'name' => (string)$model->nombre,
                'description' => (string)$model->descripcion,
                'preview' => $this->galleryDir . '/' . $af->directorio . $model->thumb,
            );
        }
        echo CJSON::encode($resp);
    }
}
