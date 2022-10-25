<template>
  <div>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Colaboradores</h1>
    <div class="my-2">
      <button
        @click="abrirModal('registrar')"
        class="btn btn-primary btn-icon-split btn-sm"
        data-toggle="modal"
        data-target="#registerModal"
        id="btn_registrar_colaborador"
      >
        <span class="icon text-white-50">
          <fa icon="plus" />
        </span>
        <span class="text">Registrar Colaborador</span>
      </button>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="table-responsive">
          <table
            class="table table-bordered"
            id="dataTable"
            width="100%"
            cellspacing="0"
          >
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Dni</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="colaborador in colaboradores"
                v-bind:key="colaborador.id"
              >
                <td>{{ colaborador.id }}</td>
                <td>{{ colaborador.nombre }}</td>
                <td>{{ colaborador.apellido }}</td>
                <td>{{ colaborador.dni }}</td>
                <td class="text-center">
                  <button
                    data-toggle="tooltip"
                    title="Editar colaborador"
                    @click="abrirModal('editar', colaborador)"
                    class="btn btn-warning btn-circle btn-sm"
                  >
                    <fa icon="edit" />
                  </button>
                  <button
                    @click="estadoColaborador(colaborador.id, 'habilitado')"
                    v-if="colaborador.estado == 'deshabilitado'"
                    data-toggle="tooltip"
                    title="Activar colaborador"
                    class="btn btn-success btn-circle btn-sm"
                  >
                    <fa icon="check" />
                  </button>
                  <button
                    @click="estadoColaborador(colaborador.id, 'deshabilitado')"
                    v-else-if="colaborador.estado == 'habilitado'"
                    data-toggle="tooltip"
                    title="Desactivar colaborador"
                    class="btn btn-danger btn-circle btn-sm"
                  >
                    <fa icon="ban" />
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Modal-->
    <div
      class="modal fade"
      id="registerModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              {{ opcion_modal == 1 ? "Registrar" : "Editar" }} colaborador
            </h5>
            <button
              class="close"
              type="button"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-12">
                <div class="row">
                  <div class="col-12 form-group">
                    <label for="nombre">Nombre:</label>
                    <input
                      type="text"
                      :class="[
                        'form-control',
                        errores.nombre ? 'is-invalid' : '',
                      ]"
                      v-model="formulario.nombre"
                      id="nombre"
                    />
                    <div v-if="errores.nombre" class="invalid-feedback">
                      {{ errores.nombre[0] }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row">
                  <div class="col-12 form-group">
                    <label for="apellido">Apellidos:</label>
                    <input
                      type="text"
                      :class="[
                        'form-control',
                        errores.apellido ? 'is-invalid' : '',
                      ]"
                      v-model="formulario.apellido"
                      id="apellido"
                    />
                    <div v-if="errores.apellido" class="invalid-feedback">
                      {{ errores.apellido[0] }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row">
                  <div class="col-12 form-group">
                    <label for="dni">DNI:</label>
                    <input
                      type="text"
                      :class="['form-control', errores.dni ? 'is-invalid' : '']"
                      v-model="formulario.dni"
                      id="dni"
                    />
                    <div v-if="errores.dni" class="invalid-feedback">
                      {{ errores.dni[0] }}
                    </div>
                  </div>
                </div>
              </div>
              <div v-if="opcion_modal == 1" class="col-12">
                <div class="row">
                  <div class="col-12 form-group">
                    <label for="contraseña">Contraseña:</label>
                    <input
                      type="password"
                      :class="[
                        'form-control',
                        errores.password ? 'is-invalid' : '',
                      ]"
                      v-model="formulario.contraseña"
                      id="contraseña"
                    />
                    <div v-if="errores.password" class="invalid-feedback">
                      {{ errores.password[0] }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              class="btn btn-secondary"
              type="button"
              data-dismiss="modal"
            >
              Cancelar
            </button>
            <button
            id="registrar_colaborador"
              v-if="opcion_modal == 1"
              @click="registrarColaborador()"
              class="btn btn-primary"
            >
              Registrar
            </button>
            <button v-else @click="editarColaborador()" class="btn btn-warning">
              Editar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      colaboradores: [],
      loader: false,
      formulario: {},
      errores: {},
      opcion_modal: 1,
    };
  },

  mounted() {
    this.listarColaboradores();
    this.iniciarFormulario();
  },

  methods: {
    iniciarTabla(response) {
      this.$nextTick(() => {
        $("#dataTable").DataTable();
      });
    },

    iniciarFormulario() {
      $("#registerModal").modal("hide");
      this.formulario = {
        id:"",
        nombre: "",
        apellido: "",
        dni: "",
        estado: "",
        contraseña: "",
      };
    },

    mostrarAlerta() {
      var mensaje = "Colaborador registrado correctamente";
      if (this.opcion_modal == 1) {
        mensaje = "Colaborador registrado correctamente";
      } else if (this.opcion_modal == 2) {
        mensaje = "Colaborador actualizado correctamente";
      } else if (this.opcion_modal == 3) {
        mensaje = "Colaborador desactivado correctamente";
      } else {
        mensaje = "Colaborador activado correctamente";
      }
      this.$swal.fire({
        position: "top-end",
        icon: "success",
        title: mensaje,
        showConfirmButton: false,
        timer: 1500,
      });
    },

    abrirModal(tipo_accion, colaborador) {
      this.errores = {};
      if (tipo_accion == "registrar") {
        this.opcion_modal = 1;
        this.iniciarFormulario();
      } else {
        this.opcion_modal = 2;
        this.formulario = colaborador;
      }
      $("#registerModal").modal("show");
    },

    listarColaboradores: function () {
      axios
        .get("/colaboradores/list")
        .then((response) => {
          this.colaboradores = response.data.data;
          this.iniciarTabla();
        })
        .catch((error) => {
          console.log(error);
        });
    },

    registrarColaborador: function () {
      const formdata = new FormData();
      formdata.append("nombre", this.formulario.nombre);
      formdata.append("apellido", this.formulario.apellido);
      formdata.append("dni", this.formulario.dni);
      formdata.append("password", this.formulario.contraseña);
      formdata.append("password_confirmation", this.formulario.contraseña);

      axios
        .post("/colaboradores/store", formdata)
        .then((response) => {
          this.iniciarFormulario();
          this.listarColaboradores();
          this.mostrarAlerta();
        })
        .catch((error) => {
          this.errores = error.response.data.errors;
          console.log(error.response.data);
        });
    },

    editarColaborador: function () {
      const formdata = new FormData();
      formdata.append("id", this.formulario.id);
      formdata.append("nombre", this.formulario.nombre);
      formdata.append("apellido", this.formulario.apellido);
      formdata.append("dni", this.formulario.dni);
      formdata.append("estado", this.formulario.estado);
      axios
        .post("/colaboradores/update", formdata)
        .then((response) => {
          this.iniciarFormulario();
          this.mostrarAlerta();
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },

    estadoColaborador: function (id, estado) {
      if (estado == "habilitado") {
        this.opcion_modal = 4;
      } else {
        this.opcion_modal = 3;
      }
      const formdata = new FormData();
      formdata.append("id", id);
      formdata.append("estado", estado);
      axios
        .post("/colaboradores/status", formdata)
        .then((response) => {
          this.iniciarFormulario();
          this.mostrarAlerta();
          this.listarColaboradores();
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },
  },
};
</script>

<style>
</style>
