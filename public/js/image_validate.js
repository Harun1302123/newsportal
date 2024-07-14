function validateImageFormat(file) {
    return true;
    const validFormats = ['image/jpeg', 'image/png'];
    return validFormats.includes(file.type);
}

function validateImageSize(file, maxSizeInMB) {
    const maxSizeInBytes = maxSizeInMB * 1024 * 1024; //MB
    return file.size <= maxSizeInBytes;
}

function validateImageDimensions(image, req_width_height) {
    const separation = req_width_height.trim().split('x');
    const req_width = parseInt(separation[0]);
    const req_height = parseInt(separation[1]);

    return req_width === image.width && req_height === image.height;
}

function previewImage(input, show_photo, max_size = '', req_width_height = '') {

    if (input.files && input.files[0]) {
        const file = input.files[0];
        const image = new Image();
        const reader = new FileReader();

        reader.onload = function (e) {
            if (!validateImageFormat(file)) {
                toastr.error('The image format is not valid! Please upload in jpg or png format.');
                return false;
            }

            if (max_size !== '' && !validateImageSize(file, max_size)) {
                toastr.error(`The image size is too large! Please upload an image smaller than ${max_size} MB.`);
                return false;
            }

            image.src = e.target.result;
            image.onload = function () {
                if (req_width_height !== '' && !validateImageDimensions(image, req_width_height)) {
                    toastr.error(`The image width & height is not valid! The image width & height must be ${req_width_height} px.`);
                    return false;
                } else {
                    $('#' + show_photo.trim()).attr('src', e.target.result);
                }
            };
        };

        reader.readAsDataURL(file);
    }
}
