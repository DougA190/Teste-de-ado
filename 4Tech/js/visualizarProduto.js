const gallery = document.querySelector('.gallery');
const mainImage = gallery.querySelector('.main-image img');
const thumbnails = gallery.querySelectorAll('.thumbnail');

thumbnails.forEach(thumbnail => {
  thumbnail.addEventListener('click', () => {
    const selectedImage = thumbnail.getAttribute('src');
    const selectedIndex = thumbnail.getAttribute('data-index');
    mainImage.setAttribute('src', selectedImage);
    thumbnails.forEach(thumbnail => thumbnail.classList.remove('selected'));
    thumbnail.classList.add('selected');
    console.log("Imagem principal atualizada para:", selectedImage);
  });
});