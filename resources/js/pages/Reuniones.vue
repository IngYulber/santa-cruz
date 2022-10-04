<template>
  <div>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Reuniones</h1>
    <div class="my-2">
      <button
        @click="abrirModal('registrar')"
        class="btn btn-primary btn-icon-split btn-sm"
        data-toggle="modal"
        data-target="#registerModal"
      >
        <span class="icon text-white-50">
          <fa icon="plus" />
        </span>
        <span class="text">Nueva reunion</span>
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
                <th>N°</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="reunion in reuniones" v-bind:key="reunion.id">
                <td>{{ reunion.id }}</td>
                <td>{{ reunion.description }}</td>
                <td>{{ reunion.fecha_programada | moment("DD/MM/YYYY") }}</td>
                <td>{{ reunion.fecha_programada | moment("hh:mm a") }}</td>
                <td class="text-center">
                  <button
                  @click="abrirModal('editar',reunion)"
                    data-toggle="tooltip"
                    title="Editar colaborador"
                    class="btn btn-warning btn-circle btn-sm"
                  >
                    <fa icon="edit" />
                  </button>
                  <button
                    @click="vistaAsistencia(reunion.id)"
                    data-toggle="tooltip"
                    title="Activar colaborador"
                    class="btn btn-success btn-circle btn-sm"
                  >
                    <fa icon="list-check" />
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
              {{ opcion_modal == 1 ? "Registrar" : "Editar" }} reunion
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
                    <label for="nombre">Descripción:</label>
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
                  <div class="col-6 form-group">
                    <label for="apellido">Fecha:</label>
                    <input
                      type="date"
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
                  <div class="col-6 form-group">
                    <label for="apellido">Hora:</label>
                    <input
                      type="time"
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
                  <div class="col-10 form-group">
                    <label for="dni">Agenda:</label>
                    <div class="row">
                      <div class="col-10">
                        <input
                          type="text"
                          :class="[
                            'form-control',
                            errores.dni ? 'is-invalid' : '',
                          ]"
                          v-model="item_agenda"
                          id="dni"
                        />
                        <div v-if="errores.dni" class="invalid-feedback">
                          {{ errores.dni[0] }}
                        </div>
                      </div>
                      <div class="col">
                        <button
                          @click="agregarAgenda()"
                          class="btn btn-primary"
                        >
                          +
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <ul
                  v-for="(item, index) in agenda"
                  v-bind:key="item.index"
                  class="list-group"
                >
                  <li class="list-group-item list-group-item-light">
                    {{ item }}
                    <button
                      @click="eliminarItemAgenda(index)"
                      class="close"
                      type="button"
                    >
                      <span>×</span>
                    </button>
                  </li>
                </ul>
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
      reuniones: [],
      loader: false,
      formulario: {},
      errores: {},
      opcion_modal: 1,
      agenda: [],
      item_agenda: "",
    };
  },

  mounted() {
    this.listarReuniones();
    this.iniciarFormulario();
  },

  methods: {
    iniciarTabla(response) {
      this.$nextTick(() => {
        $("#dataTable").DataTable();
      });
    },

    vistaAsistencia(id) {
      window.location.href = "reuniones/" + id;
    },

    iniciarFormulario() {
      $("#registerModal").modal("hide");
      this.formulario = {
        descripcion: "",
        fecha: "",
        hora: "",
      };
    },

    agregarAgenda() {
      if (this.item_agenda == "") {
        // crear error
      } else {
        this.agenda.push(this.item_agenda);
      }
    },

    eliminarItemAgenda(index) {
      this.agenda.splice(index, 1);
    },

    mostrarAlerta() {
      var mensaje = "Reunion registrado correctamente";
      if (this.opcion_modal == 1) {
        mensaje = "Reunion registrado correctamente";
      } else {
        mensaje = "Reunion actualizado correctamente";
      }
      this.$swal.fire({
        position: "top-end",
        icon: "success",
        title: mensaje,
        showConfirmButton: false,
        timer: 1500,
      });
    },

    abrirModal(tipo_accion, reunion) {
      this.errores = {};
      if (tipo_accion == "registrar") {
        this.opcion_modal = 1;
        this.iniciarFormulario();
      } else {
        this.opcion_modal = 2;
        this.formulario = reunion;
      }
      $("#registerModal").modal("show");
    },

    listarReuniones: function () {
      axios
        .get("/reuniones/list")
        .then((response) => {
          this.reuniones = response.data.data;
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
