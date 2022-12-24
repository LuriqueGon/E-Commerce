const pesquisarCEP = () => {
    const cep = $('#cep').val()

        if(cep.length >= 8){
            const xmlhttp = new XMLHttpRequest()
            xmlhttp.open("GET",`https://viacep.com.br/ws/${cep}/json/ `);

            xmlhttp.onreadystatechange=()=>{
                if(xmlhttp.readyState == 4){
                    const response = JSON.parse(xmlhttp.response)
                    // console.log(response)
                    if(response.erro){
                        console.log(1)
                        alert('CEP incorreto')
                        $('#cep').val('')
                        $('#estado').val('')
                        $('#cidade').val('')
                        $('#bairro').val('')
                        $('#logadouro').val('')
                    }else{
                        console.log(response.cep)
                        console.log(response.uf)
                        console.log(response.localidade)
                        console.log(response.bairro)
                        console.log(response.logradouro)
                        $('#cep').val(response.cep)
                        $('#estado').val(response.uf)
                        $('#cidade').val(response.localidade)
                        $('#bairro').val(response.bairro)
                        $('#logadouro').val(response.logradouro)

                    }

                }
            }

            xmlhttp.send();
        
        }
       
}