<?= $this-> include('template/header'); ?>
<?= $this-> include('template/sidebar'); ?>
<main id="main" class="main">
    <section class="section">
        <?= $this-> renderSection('content');?>
    </section>
</main>
<?= $this-> include('template/footer'); ?>