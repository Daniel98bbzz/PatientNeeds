function showSuccessMessage() {
    localStorage.setItem('isSubmitted', 'true');
    document.getElementById("check").checked = true;
    return true;
}

window.onload = function() {
    if(localStorage.getItem('isSubmitted') === 'true'){
        document.getElementById("check").checked = true;
    } else {
        document.getElementById("check").checked = false;
    }
}


function hideSuccessMessage() {
    localStorage.removeItem('isSubmitted');
    document.getElementById("check").checked = false;
}