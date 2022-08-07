function imgPreView(event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    const preview = document.getElementById("preview");
    const previewImage = document.getElementById("preview_image");
    const plusIcon = document.getElementById("plus_icon");
    const uploadText = document.getElementById("upload_text"); 
    const oldImg = document.getElementById("old_img");

    if (plusIcon && uploadText != null) {
        preview.removeChild(plusIcon);
        preview.removeChild(uploadText);
    } 

    if (previewImage != null) {
        preview.removeChild(previewImage);
    } 

    if (oldImg != null) {
        preview.removeChild(oldImg);
    }

    reader.onload = function(event) {
        const img = document.createElement("img");
        img.setAttribute("src", reader.result);
        img.setAttribute("id", "preview_image");
        preview.appendChild(img);
    } 
    
    reader.readAsDataURL(file);
}
