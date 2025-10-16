import PhotoSwipeLightbox from 'https://unpkg.com/photoswipe@5.4.4/dist/photoswipe-lightbox.esm.js';
import PhotoSwipeDynamicCaption from 'https://unpkg.com/photoswipe-dynamic-caption-plugin/photoswipe-dynamic-caption-plugin.esm.js';

const galleries = document.querySelectorAll('.pswp-gallery');

if (galleries.length > 0) {
    galleries.forEach(gallery => {
        const lightbox = new PhotoSwipeLightbox({
            gallery: gallery,
            children: 'a[data-pswp-width]',
            pswpModule: () => import('https://unpkg.com/photoswipe@5.4.4/dist/photoswipe.esm.js'),
        });

        new PhotoSwipeDynamicCaption(lightbox, { type: 'auto' });
        lightbox.init();
    });
}
