<?
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class imageUploadModel extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
			$dstImage = getcwd().'/../uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($dstImage);
            return true;
        } else {
            return false;
        }
    }
}
?>