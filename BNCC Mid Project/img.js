const avatarInput = document.getElementById('avatar');
const avatarPreview = document.getElementById('avatar-preview');

avatarInput.addEventListener('change', function () {
    const file = this.files[0];

    if (file) {
        const reader = new FileReader();

        reader.addEventListener('load', function () {
            avatarPreview.src = reader.result;
        });

        reader.readAsDataURL(file);
    } else {
        avatarPreview.src = '#';
    }
});