</main> </div> <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($js) && !empty($js)): ?>
    <?php foreach ($js as $script): ?>
        <script src="<?= base_url($script) . "?v=" . time(); ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>