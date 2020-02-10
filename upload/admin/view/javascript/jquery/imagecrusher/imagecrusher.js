function showValue(newValue, silderValueToUpdate) {
    var id = silderValueToUpdate;
    document.getElementById(id).innerHTML=newValue;
}

function deselectOn() {
    document.getElementById("image-optimise-on").checked = false;
}

function deselectOff() {
    document.getElementById("image-optimise-off").checked = false;
}

