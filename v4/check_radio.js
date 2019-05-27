function checkRadio() {
    let radios = document.getElementsByName('option');

    let selected = -1;
    for (let i = 0, length = radios.length; i < length; i++) {
        if (radios[i].checked) {
            selected = i;
            break;
        }
    }

    if (selected == -1) {
        alert ("Select something");
        return false;
    }
    else {
        return true;
    }
}
