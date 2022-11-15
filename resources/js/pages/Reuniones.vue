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
        <span class="text">Nueva reunión</span>
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
                    @click="abrirModal('editar', reunion)"
                    data-toggle="tooltip"
                    title="Editar Reunión"
                    class="btn btn-warning btn-circle btn-sm"
                  >
                    <fa icon="edit" />
                  </button>
                  <button
                    @click="vistaAsistencia(reunion.id)"
                    data-toggle="tooltip"
                    title="Tomar asistencia"
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
              {{ opcion_modal == 1 ? "Nueva" : "Editar" }} reunión
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
                        errores.description ? 'is-invalid' : '',
                      ]"
                      v-model="formulario.description"
                      id="nombre"
                    />
                    <div v-if="errores.description" class="invalid-feedback">
                      {{ errores.description[0] }}
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
                        errores.fecha_programada ? 'is-invalid' : '',
                      ]"
                      v-model="formulario.fecha"
                      id="apellido"
                    />
                    <div
                      v-if="errores.fecha_programada"
                      class="invalid-feedback"
                    >
                      {{ errores.fecha_programada[0] }}
                    </div>
                  </div>
                  <div class="col-6 form-group">
                    <label for="apellido">Hora:</label>
                    <input
                      type="time"
                      :class="[
                        'form-control',
                        errores.fecha_programada ? 'is-invalid' : '',
                      ]"
                      v-model="formulario.hora"
                      id="apellido"
                    />
                    <div
                      v-if="errores.fecha_programada"
                      class="invalid-feedback"
                    >
                      {{ errores.fecha_programada[0] }}
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
              @click="registrarReunion()"
              class="btn btn-primary"
              :disabled="loader"
            >
              <span
                class="spinner-border spinner-border-sm mb-1"
                role="status"
                aria-hidden="true"
                v-show="loader"
              ></span>
              {{ loader ? "Registrando" : "Registrar" }}
            </button>
            <button v-else @click="editarReunion()" class="btn btn-warning">
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
        id: "",
        description: "",
        fecha: "",
        hora: "",
      };
      this.agenda = [];
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
        this.formulario.fecha = this.$moment(reunion.fecha_programada).format(
          "YYYY-MM-DD"
        );
        this.formulario.hora = this.$moment(reunion.fecha_programada).format(
          "HH:mm"
        );
      }
      $("#registerModal").modal("show");
    },

    listarReuniones: async function () {
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

    registrarReunion: function () {
         this.loader = true;
      const formdata = new FormData();
      formdata.append("description", this.formulario.description);
      formdata.append(
        "fecha_programada",
        this.formulario.fecha + " " + this.formulario.hora
      );
      formdata.append("asuntos", JSON.stringify(this.agenda));

      axios
        .post("/reuniones/store", formdata)
        .then((response) => {
          this.iniciarFormulario();
          this.mostrarAlerta();
          this.listarReuniones();
          this.iniciarTabla();
           this.loader = false;
        })
        .catch((error) => {
          this.errores = error.response.data.errors;
           this.loader = false;
        });
    },

    editarReunion: function () {
      const formdata = new FormData();
      formdata.append("id", this.formulario.id);
      formdata.append("description", this.formulario.description);
      formdata.append(
        "fecha_programada",
        this.formulario.fecha + " " + this.formulario.hora
      );
      formdata.append("asuntos", JSON.stringify(this.agenda));
      axios
        .post("/reuniones/update", formdata)
        .then((response) => {
          this.iniciarFormulario();
          this.mostrarAlerta();
          this.listarReuniones();
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
