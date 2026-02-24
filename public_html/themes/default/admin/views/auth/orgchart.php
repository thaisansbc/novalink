<link rel="stylesheet" href="<?= base_url();?>themes/default/admin/assets/js/orgchart/css/jquery.orgchart.css">
<script src="<?= base_url();?>themes/default/admin/assets/js/orgchart/js/jquery.orgchart.js"></script>
<script src="<?= base_url();?>themes/default/admin/assets/js/orgchart/js/html2canvas.min.js"></script>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-sitemap"></i> <?= lang('binary_model'); ?></h2>
    </div>
    <div class="box-content">
        <div id="chart-container"></div>
    </div>
</div>

<style>
#chart-container {
    height: 600px;
    width: 100%;
    border: 1px dashed #aaa;
    overflow: auto;
    text-align: center;
}
.orgchart { background: #fff; }
</style>

<script>
$(function() {
    var datascource = <?= json_encode($tree); ?>;

    $('#chart-container').orgchart({
        'data': datascource,
        'nodeContent': 'title',
        'exportButton': true,
        'exportFilename': 'Node_Chart',
        'pan': true,
        'zoom': true,
        'direction': 't2b'
    });
});
</script>
