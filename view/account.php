
<a class="btn btn-default" href="<?=$GLOBALS['appurl']?>/account/edit">Meine Kontodaten bearbeiten</a>
<br>
<br>
<a class="btn btn-danger" onclick="confirmDelete()">Mein Konto löschen</a>

<script>
    function confirmDelete(){
        if (confirm("Möchten Sie Ihr Konto wirklich löschen?")){
            location.href = "<?=$GLOBALS['appurl'] . "/account/delete"?>";
        }
    }
</script>