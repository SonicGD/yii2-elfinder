<?php
namespace elfinder;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\InputWidget;

/**
 * Class ElFinder
 * @package elfinder
 */
class ElFinder extends InputWidget
{
    public $connectorUrl = 'files/list';
    public $lang = 'ru';
    public $width = 840;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $view = $this->getView();
        ELFinderAsset::register($view);
        $input = $this->getInput('fileInput');
        $id = 'jQuery("#' . $this->options['id'] . '")';
        $browseId = $this->options['id'] . '-browse';
        $input .= '<span id="' . $browseId . '"></span>';

        $connectorUrl = Url::toRoute($this->connectorUrl);

        $scirpt = <<<EOF
        jQuery(#{$browseId}).click(function(){
        $('<div/>').dialogelfinder({
            url: '{$connectorUrl}',
            lang: '{$this->lang}',
            width: {$this->width},
            destroyOnClose: true,
            getFileCallback: function (files, fm) {
                {$id}.val(files);
            },
            commandsOptions: {
                getfile: {
                    oncomplete: 'close',
                    folders: true
                }
            }
        }).dialogelfinder('instance');
        });
EOF;

        $view->registerJs($scirpt);
        echo $input;
    }

    /**
     * @param      $type
     * @param bool $list
     * @return mixed
     */
    protected function getInput($type, $list = false)
    {
        if ($this->hasModel()) {
            $input = 'active' . ucfirst($type);
            return $list ?
                Html::$input($this->model, $this->attribute, $this->data, $this->options) :
                Html::$input($this->model, $this->attribute, $this->options);
        }
        $input = $type;
        $checked = false;
        if ($type == 'radio' || $type == 'checkbox') {
            $this->options['value'] = $this->value;
            $checked = ArrayHelper::remove($this->options, 'checked', '');
            if (empty($checked) && !empty($this->value)) {
                $checked = ($this->value == 0) ? false : true;
            } elseif (empty($checked)) {
                $checked = false;
            }
        }
        return $list ?
            Html::$input($this->name, $this->value, $this->data, $this->options) :
            (($type == 'checkbox' || $type == 'radio') ?
                Html::$input($this->name, $checked, $this->options) :
                Html::$input($this->name, $this->value, $this->options));
    }
}