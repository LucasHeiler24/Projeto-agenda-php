$(function () {
    let grafico1Registros = null;

    //Ocultando a tela de registro e editar
    $('#telaRegistro').hide();
    $('#formEditar').hide();

    //Mostrando ao clicar no botão registrar
    $('#btnRegistro').click(function () {
        $('#telaRegistro').slideDown(2000);
    });

    //Fechando ao clicar no icone de fechar
    $('#fecharRegistro').click(function () {
        $('#telaRegistro').hide();
    });

    $('.alert').css({ 'width': '50%', 'margin': 'auto' }).fadeOut(8000);

    //Pegando e atribuindo as datas
    let dataLocal = new Date();
    let ano = dataLocal.getFullYear();
    let mes = dataLocal.getMonth();
    $('#diaAtual').text(dataLocal.toLocaleDateString());

    //Fiz o vetor dos meses
    const vetorMeses = [
        'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio',
        'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro',
        'Novembro', 'Dezembro'
    ];

    //Atribuindo o mes e o ano pro usuário
    $('#dataEscolhida').text(vetorMeses[mes] + " / " + ano);

    //Atribuindo ao contador o mes atual 
    let cont = mes;
    let formatarMes = (cont + 1).toString().padStart(2, '0');
    let concatenar = ano + "-" + formatarMes;
    dadosUsuario(concatenar);

    //Adiciono um ouvinte nos icones de aumentar e diminuir mês
    $('#aumentarMes').click(function () {
        //Incremento o contador
        cont++;
        //Verefico se chegou a 12
        if (cont == 12) {
            //Atribuo 0 ao contador
            cont = 0;
            //Incremento o ano
            ano++;
        }
        //Mostro pro usuário
        $('#dataEscolhida').text(vetorMeses[cont] + " / " + ano);
        let formatarMes = (cont + 1).toString().padStart(2, '0');
        concatenar = ano + "-" + formatarMes;
        dadosUsuario(concatenar);
    });

    $('#diminuirMes').click(function () {
        cont--;
        if (cont == -1) {
            cont = 11;
            ano--;
        }
        $('#dataEscolhida').text(vetorMeses[cont] + " / " + ano);
        let formatarMes = (cont + 1).toString().padStart(2, '0');
        concatenar = ano + "-" + formatarMes;
        dadosUsuario(concatenar);
    });

    //Aqui eu fiz uma função que formata as datas 
    function formatarData(data) {
        const strData = data.split('-');
        return strData[2] + "/" + strData[1] + "/" + strData[0];
    }

    const tBody = document.querySelector('tbody');

    //Aqui eu faço a requisição para a minha página pho aonde pega os dados do banco de dados
    async function dadosUsuario(concatenar) {
        const idRegistroCategoria = [];
        const corRegistroCategoria = [];
        const nomeRegistroCategoria = [];

        //Faço a requisição dos dados dos registros
        const resposta = await fetch(`filtrar_registros.php?data=${concatenar}`)
        //Verefico se a requisição foi bem sucedida
        if (!resposta.ok)
            throw new Error(`Erro ao fazer a requisição ${resposta.status}`);
        const dadosRegistos = await resposta.json();

        if (dadosRegistos.length > 0) {
            //Escondo o texto que não possui registro e mostro a tabel
            $('#possuiRegistros').hide();
            $('table').show();
            //Limpo os registros pra evitar duplicados
            tBody.innerHTML = "";

            /*Faço um for que repete ate a quantidade do tamanho dos registros que é a quantidade de
            categorias que o usuário possui*/
            for (let posRegistro = 0; posRegistro < dadosRegistos.length; posRegistro++) {
                idRegistroCategoria.push(dadosRegistos[posRegistro].categorias_id);

                //Faço a requisição para a página php aonde pego as categorias no banco de dados
                const respostaCategoria = await fetch(`filtrar_categorias.php?idCategoria=${dadosRegistos[posRegistro].categorias_id}`)
                if (!resposta.ok)
                    throw new Error(`Erro ao fazer a requisição ${resposta.status}`);
                const dadosCategoria = await respostaCategoria.json();

                //Itero sobre os itens que tem nos vetores de objetos
                dadosCategoria.forEach((conteudo, i) => {
                    corRegistroCategoria.push(conteudo.corCategoria);
                    nomeRegistroCategoria.push(conteudo.nomeCategoria);

                    //Construo minha tabela
                    let tr = document.createElement('tr');
                    let td1 = document.createElement('td');
                    let td2 = document.createElement('td');
                    let td3 = document.createElement('td');
                    let td4 = document.createElement('td');
                    let td5 = document.createElement('td');
                    let icone = document.createElement('img');
                    let btnEditar = document.createElement('button');
                    let btnExcluir = document.createElement('a');

                    td1.style = `background-size: cover; height:auto; width:auto; background:${dadosCategoria[i].corCategoria};
                    display: flex; justify-content: center; align-itens: center;`;
                    icone.src = `assets/img/${dadosCategoria[i].iconeCategoria}`;
                    td1.appendChild(icone);
                    td2.textContent = dadosRegistos[posRegistro].nomeRegistro;
                    td3.textContent = formatarData(dadosRegistos[posRegistro].dataRegistro);
                    if (dadosRegistos[posRegistro].situacao) td4.textContent = "Feito";
                    else td4.textContent = "Pendente";
                    td5.style = 'display:flex; flex-direction:column; gap:10px';

                    //Aqui adiciono a interatividade dos botões
                    btnEditar.classList.add('editarRegistros');
                    btnEditar.setAttribute('dadosId', dadosRegistos[posRegistro].id);
                    btnEditar.textContent = "Editar";
                    btnEditar.value = `${dadosRegistos[posRegistro].id}`;
                    btnEditar.style = 'color: #fff; border: none;  height:5vh; border-radius: 5px; background:rgb(212, 32, 0); cursor: pointer;';
                    btnExcluir.textContent = "Excluir";
                    btnExcluir.href = `excluir_registro.php?id=${dadosRegistos[posRegistro].id}`;
                    btnExcluir.style = 'color: #fff; border-radius: 5px; height:5vh; background: #a0114d; cursor: pointer';

                    //Caso clique em editar faço uma requisição da página php por fetch
                    btnEditar.addEventListener('click', function () {
                        let id = this.value;
                        fetch(`filtrar_editar.php?idRegistro=${id}`)
                            .then(resposta => {
                                if (!resposta.ok)
                                    throw new Error(`Erro na requisição ${resposta.status}`);
                                return resposta.json();
                            })
                            .then(dadosEditar => {
                                $('#formEditar').slideDown(2000);
                                console.log(dadosEditar);
                                document.getElementById('inNomeEditar').value = dadosEditar[0].nomeRegistro;
                                document.getElementById('inDataEditar').value = dadosEditar[0].dataRegistro;
                                document.getElementById('inIdEditar').value = dadosEditar[0].id;
                            })
                            .catch(erro => console.log(erro));
                    });

                    td5.appendChild(btnEditar);
                    td5.appendChild(btnExcluir);

                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tr.appendChild(td3);
                    tr.appendChild(td4);
                    tr.appendChild(td5);
                    tBody.appendChild(tr);
                });

            }
        } else {
            //Caso não tenha registros nesse mês escondo a tabela e mostro o texto
            $('table').hide();
            $('#possuiRegistros').show();
        }

        const totalIdRegistro = [];

        //Aqui eu conto quantas vezes possui a quantidade de categorias no mês
        for (let i = 0; i < idRegistroCategoria.length; i++) {
            let contId = 1;
            for (let j = i + 1; j < idRegistroCategoria.length; j++) {
                if (idRegistroCategoria[i] == idRegistroCategoria[j]) {
                    contId++;
                }
            }
            totalIdRegistro.push(contId);

            //Aqui eu removo as duplicatas que tem no meu vetor
            for (let z = i + 1; z < idRegistroCategoria.length; z++) {
                if (idRegistroCategoria[i] == idRegistroCategoria[z]) {
                    idRegistroCategoria.splice(z, contId-1);
                    nomeRegistroCategoria.splice(z, contId-1);
                    corRegistroCategoria.splice(z, contId-1);
                }
            }
        }

        
        //Criando meu gráfico ao clicar no botão
        $('#btnGraficos').click(function () {
            let grafico1 = document.getElementById('grafico1').getContext('2d');

            if (grafico1Registros) {
                grafico1Registros.destroy();
            }

            grafico1Registros = new Chart(grafico1, {
                type: 'pie',
                data: {
                    labels: nomeRegistroCategoria,
                    datasets: [{
                        label: 'Quantidade de registros por categoria',
                        data: totalIdRegistro,
                        backgroundColor: corRegistroCategoria,
                        borderColor: corRegistroCategoria,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: 'block',
                            color: '#fff'
                        },
                        title: {
                            display: true,
                            text: 'Registros por categoria no mês',
                            color: '#fff'
                        }
                    },
                    scales: {
                        y: {
                            display: false
                        }
                    }
                }
            });
        });
    }
});