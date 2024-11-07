function previewPhoto(event) {
    const photo = document.getElementById('currentPhoto');
    photo.src = URL.createObjectURL(event.target.files[0]);
    photo.style.display = 'block';
}