function start_edit() {
    document.getElementById('user-detail').style.display = 'none';
    document.getElementById('edit-detail').style.display = '';
    document.getElementById('edit-detail').detail.value =
        document.getElementById('user-detail').innerHTML;

    var me = document.getElementById('editor');
    me.innerHTML = 'discard';
    me.onclick = discard_edit;
}

function discard_edit() {
    document.getElementById('user-detail').style.display = '';
    document.getElementById('edit-detail').style.display = 'none';

    var me = document.getElementById('editor');
    me.innerHTML = 'edit';
    me.onclick = start_edit;
}
