<?php if(!defined('basePath')) exit('No direct script access allowed');

$query = "select * from ".$this->table_prefix."faq where publish='1' order by faq_order";
$faq = $this->db->getAll($query);

$faqList = '';
foreach($faq as $val){
    $faqList .= '
        <div class="faq-item">
            <button class="btn btn-block collapsed" type="button" data-toggle="collapse" data-target=".faq-'.$val['faq_id'].'" aria-expanded="false">'.$val['question'].'</button>
            <div class="collapse faq-'.$val['faq_id'].'">
                <div class="card card-body">
                    '.htmlspecialchars_decode(html_entity_decode($val['answer'])).'
                </div>
            </div>
        </div>
    ';
}
?>
<section>
    <div class="container">
        <h2 class="heading text-center">FAQ</h2>
        <?php echo $faqList; ?>
    </div>
</section>
