<?php

/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 10/2/16
 * Time: 2:13 AM
 */
class ShowDisplay{

    protected $cs;
//    protected $data_table;
    protected $data_show;
    protected $data_show_result;
    protected $red = '';
    protected $pink = '' ;
    protected $purple = '' ;
    protected $deepPurple = '';
    protected $indigo = '';
    protected $blue  = '';
    protected $lightBlue = '';
    protected $cyan  = '';
    protected $teal  = '#26A69A';
    protected $green = '#66BB6A';

    protected $hue50 = ['#FFEBEE','#FCE4EC','#F3E5F5','#EDE7F6','#E8EAF6','#E3F2FD','#E1F5FE','#E0F7FA','#E0F2F1','#E8F5E9','#FFFDE7','#FFF3E0','#EFEBE9','#EEEEEE','#ECEFF1',];


    public function __construct($data_display){
        $args = func_get_args();


        $this->data_table = $data_display;

        $data_TransFunc =  $this->data_table->TF_each;
        $data_DF =  $this->data_table->DF;
        $data_DFi =  $this->data_table->DDFi;
        $data_IDF =  $this->data_table->idf;
        $data_WTI =  $this->data_table->w_tfidf;
        $data_DP =  $this->data_table->DotProd;
        $data_VL =  $this->data_table->VectorLength;

        $this->data_show_result =  $this->data_table->show_result;

        $this->data_show = array_merge_recursive(
            $data_TransFunc,
            $data_DF,
            $data_DFi,
            $data_IDF,
            $data_WTI,
            $data_DP,
            $data_VL
        );

    }

    public function preview($var){
        echo '<pre>';
        print_r($var);
        echo '</pre>';

    }

    public function TableShow(){

        function print_row(&$item, $key) {
            echo('<tr>'.'<td>'.$key.'</td><td>'.implode('</td><td>', $item).'</td>'.'</tr>');
        }

        ?>

        <table border="0" width="90%" align="center">
        <tr>
            <th rowspan="2" bgcolor="<?=$this->hue50[0];?>">Word</th>
            <th colspan="<?php echo $this->data_table->num_d + 1; ?>" bgcolor="<?=$this->hue50[3];?>">Term Frequency</th>
            <th rowspan="2" bgcolor="<?=$this->hue50[4];?>">DF</th>
            <th rowspan="2" bgcolor="<?=$this->hue50[9];?>">D/DF</th>
            <th rowspan="2" bgcolor="<?=$this->hue50[10];?>">idf</th>
            <th colspan="<?php echo $this->data_table->num_d + 1; ?>" bgcolor="<?=$this->hue50[11];?>">W = TFxIDF</th>
            <th colspan="<?php echo $this->data_table->num_d; ?>" bgcolor="<?=$this->hue50[12];?>">q x d</th>
            <th colspan="<?php echo $this->data_table->num_d + 1; ?>" bgcolor="<?=$this->hue50[14];?>">Vector Length</th>
        </tr>
        <tr>
            <th bgcolor="<?=$this->hue50[0];?>">q</th>
            <?php for ($i = 0; $i < $this->data_table->num_d; $i++) {
                $a = 1;
                echo '<th bgcolor="' . $this->hue50[$a++].'">d' . $i . '</th>';
            } ?>
            <th bgcolor="#ffebcd">q</th>
            <?php for ($i = 0; $i < $this->data_table->num_d; $i++) {
                echo '<th bgcolor="'. $this->hue50[$a].'">d' . $i . '</th>';
            } ?>
            <?php for ($i = 0; $i < $this->data_table->num_d; $i++) {
                echo '<th bgcolor="'. $this->hue50[$a++].'">d' . $i . '</th>';
            } ?>
            <th>q</th>
            <?php for ($i = 0; $i < $this->data_table->num_d; $i++) {
                echo '<th bgcolor="'. $this->hue50[$a].'">d' . $i . '</th>';
            } ?>
        </tr>
        <?php array_walk( $this->data_show, 'print_row'); ?>
        </table>

        <?php
    }


    /** Show Result of Search as List
     *
     */
    public function TableShowResult(){
?>
        <style>
            .error-notice {
                margin: 5px 5px; /* Make sure to keep some distance from all side */
            }

            .oaerror {
                width: 90%; /* Configure it fit in your design  */
                margin: 0 auto; /* Centering Stuff */
                background-color: #FFFFFF; /* Default background */
                padding: 20px;
                border: 1px solid #eee;
                border-left-width: 5px;
                border-radius: 3px;
                margin: 0 auto;
                font-family: 'Open Sans', sans-serif;
                font-size: 16px;
            }

            .danger {
                border-left-color: #d9534f; /* Left side border color */
                background-color: rgba(217, 83, 79, 0.1); /* Same color as the left border with reduced alpha to 0.1 */
            }

            .danger strong {
                color: #d9534f;
            }

            .warning {
                border-left-color: #f0ad4e;
                background-color: rgba(240, 173, 78, 0.1);
            }

            .warning strong {
                color: #f0ad4e;
            }

            .info {
                border-left-color: #5bc0de;
                background-color: rgba(91, 192, 222, 0.1);
            }

            .info strong {
                color: #5bc0de;
            }

            .success {
                border-left-color: #2b542c;
                background-color: rgba(43, 84, 44, 0.1);
            }

            .success strong {
                color: #2b542c;
            }

        </style>
<?php
        function print_list(&$item, $key) {
//            echo('<ul class="ul">'.'<li>'.$key.'</li><li>'.implode('%</li><li>', $item).'</li>'.'</ul>');

            echo (
                '<div class="row">'.
                '<div class="col-md-100 col-md-offset-0">'.
                '<br><br>'.
                '<div class="error-notice">'.
                '<div class="oaerror danger">'.
                '<strong>Title</strong> - '. $item[1].
                '</div>'.
                '<div class="oaerror warning">'.
                '<strong>Url</strong> - <a href="<?= $row[\'url\'] ?>"><?= $row[\'url\'] ?></a>'.
                '</div>'.
                '<div class="oaerror info">'.
                '<strong>Page Rank</strong> - <?= $row[\'pr\'] ?>'.
                '</div>'.
                '<div class="oaerror success">'.
                '<strong>TF-IDF: '.$item[0].' &amp; HITS</strong> - <?= "0" ?>'.
                '</div>'.
                '</div>'.
                '</div>'.
                '</div>'
            );

        }
        ?>
        <table border="1">
            <?php

            $results_data = $this->data_table->getShowResult();

//            $this->preview($this->data_table->getShowResult());
//            array_walk($this->data_table->getShowResult(), 'print_list');

            array_walk($results_data, 'print_list');
            ?>
        </table>

<!--        ALTERNATE -->



        <?php
    }


}
