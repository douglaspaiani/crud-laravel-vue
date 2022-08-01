<template>
<div class="container mt-5">
  <div class="row">
  <div class="col-4 d-grid gap-2 d-md-flex">
    <input type="text" class="form-control" placeholder="Buscar por nome ou e-mail" v-model="search">
  </div>
    <div class="col-8 d-grid gap-2 d-md-flex justify-content-md-end">
    <button type="button" @click="add()" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary">Cadastrar novo usuário</button>
    </div>
    </div>
<table class="table mt-5">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nome</th>
      <th scope="col">Email</th>
      <th scope="col">CPF</th>
      <th scope="col">Celular</th>
      <th scope="col">Ações</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="username in itensFiltrados" :key="username.id">
      <th scope="row">{{username.id}}</th>
      <td>{{username.nome}}</td>
      <td>{{username.email}}</td>
      <td>{{username.cpf}}</td>
      <td>{{username.celular}}</td>
      <td><button type="button" @click="deletaUsuario(username.id)" class="btn btn-danger"
        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
  Excluir
</button>
<button type="button" @click="editaUsuario(username.id)" data-bs-toggle="modal" data-bs-target="#update" class="btn btn-primary"
        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
  Editar
</button></td>
    </tr>
  </tbody>
</table>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cadastrar novo usuário</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
            <div class="form-group mt-1">
                <label>Nome completo</label>
                <input type="text" v-model="user.nome" class="form-control" name="nome" required>
            </div>
            <div class="form-group mt-1">
                <label>Email</label>
                <input type="email" v-model="user.email" class="form-control" name="email" required>
            </div>
            <div class="form-group mt-1">
                <label>CPF</label>
                <input type="text" v-mask="['###.###.###-##']" v-model="user.cpf" class="form-control" name="cpf" required>
            </div>
            <div class="form-group mt-1">
                <label>Celular</label>
                <input type="text" v-mask="['(##) #####-####']" v-model="user.celular" class="form-control" name="celular" required>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary fechar" data-bs-dismiss="modal">Fechar</button>
        <button type="button" @click="cadastrar()" class="btn btn-primary open">Cadastrar usuário</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Atualizar usuário</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
            <div class="form-group mt-1">
                <label>Nome completo</label>
                <input type="text" v-model="user.nome" class="form-control" name="nome" required>
            </div>
            <div class="form-group mt-1">
                <label>Email</label>
                <input type="email" v-model="user.email" class="form-control" name="email" required>
            </div>
            <div class="form-group mt-1">
                <label>CPF</label>
                <input type="text" v-mask="['###.###.###-##']" v-model="user.cpf" class="form-control" name="cpf" required>
            </div>
            <div class="form-group mt-1">
                <label>Celular</label>
                <input type="text" v-mask="['(##) #####-####']" v-model="user.celular" class="form-control" name="celular" required>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary fechar" data-bs-dismiss="modal">Fechar</button>
        <button type="button" @click="salvar(user.id)" class="btn btn-primary open">Salvar alterações</button>
      </div>
    </div>
  </div>
</div>

</div>
</template>
<script>
import usuarios from '../services/usuarios'
import {mask} from 'vue-the-mask'
export default {
    components: {mask},
    data(){
        return {
            search: "",
            listagem: [],
            user: {
              id: null,
              nome: '',
              email: '',
              cpf: '',
              celular: ''
            },
        };
    },
    computed: {
      itensFiltrados(){
        let busca = [];
        busca = this.listagem.filter((item)=>{
          return (
            item.nome.toLowerCase().indexOf(this.search.toLowerCase()) > -1 ||
            item.email.toLowerCase().indexOf(this.search.toLowerCase()) > -1
          );
        });
        return busca;
      }
    },
    methods: {
      listAll() {
        usuarios.getAll()
          .then(response => {
            this.listagem = response.data;
            console.log(response.data);
          })
          .catch(e => {
            console.log(e);
          });
      },
      add(){
        this.user.nome = '',
        this.user.email = '',
        this.user.cpf = '',
        this.user.celular = '',
        this.user.id = ''
      },
      cadastrar(){
        var data = {
            nome: this.user.nome,
            email: this.user.email,
            cpf: this.user.cpf,
            celular: this.user.celular,
        };
        usuarios.create(data)
            .then(response => {
              this.listagem = ''
              this.listAll();
              $('.fechar').click();
            })
            .catch(e => {
              console.log(e);
            });
      },
      salvar(id){
        var data = {
            nome: this.user.nome,
            email: this.user.email,
            cpf: this.user.cpf,
            celular: this.user.celular,
        };
        usuarios.update(id, data)
            .then(response => {
              this.listagem = ''
              this.listAll();
              $('.fechar').click();
            })
            .catch(e => {
              console.log(e);
            });
      },
      editaUsuario(id){
        usuarios.getID(id)
          .then(response => {
            this.user.nome = response.data.nome;
            this.user.email = response.data.email;
            this.user.celular = response.data.celular;
            this.user.cpf = response.data.cpf;
            this.user.id = response.data.id;
            console.log(response.data);
          })
          .catch(e => {
            console.log(e);
          });
      },
      deletaUsuario(id){
            usuarios.delete(id)
            .then((response)=>{
                this.listagem = ''
                this.listAll();
            })
            .catch(e => {
                console.log(e);
            });
      }
    },
    created(){
      listagem: usuarios.getAll().then((response)=>{
                this.listagem = response.data;
                console.log(response.data);
            }).catch(e => {
                console.log(e);
                });
    }
}

</script>
<style scoped>
.btn-danger {
  margin-right: 4px;
}
</style>