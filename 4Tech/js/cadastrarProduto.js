function previewImagens() {
    var imagens = document.querySelector('input[name="imagem[]"]').files;
    var previews = document.querySelector('#previews');
    var radios = document.querySelector('#radios');

    previews.innerHTML = '';
    radios.innerHTML = '';

    if (imagens.length > 0) {
        for (var i = 0; i < imagens.length; i++) {
            var previewDiv = document.createElement('div');
            previewDiv.className = 'preview';
            previewDiv.style.display = 'inline-block';
            previewDiv.style.marginRight = '10px';
            previews.appendChild(previewDiv);

            var preview = document.createElement('img');
            preview.style.width = '90px';
            preview.style.height = '90px';
            previewDiv.appendChild(preview);

            var reader = new FileReader();
            reader.onload = (function (preview) {
                return function (e) {
                    preview.src = e.target.result;
                };

            })(preview);
            reader.readAsDataURL(imagens[i]);
           
          radios.innerHTML += "<p><label><input name='isprincipal' type='radio' value='" + i + "' style= 'display=inline-block' ><span></span></label></p>";

          radios.style.display = "inline-block";
          radios.style.marginRight = "0px";
            
            
             
        }
    }
    
    
    
}










 // var radio = document.createElement('input');
            // radio.className = 'row';
            // radio.type = 'radio';
            // radio.name = 'isprincipal'+i;
            // radio.id = 'isprincipal' + i;
            // radio.value = i;
            // radio.style.width = '50px';  
           
            //radios.appendChild.innerHTML = "<p><label><input name='group1' type='radio'><span>teste</span></label></p>";;

            // var checkbox = document.querySelector('#isprincipal');
            // checkbox.disabled = false;

            
            // var radioLabel = document.createElement("span");
            // radioLabel.htmlFor = 'isprincipal' + i;
            // radioLabel.innerText = '';
            // radioLabel.style.marginRight = '75px';
            // radios.appendChild(radioLabel);    