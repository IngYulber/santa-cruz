<template>
  <div>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Sanciones</h1>
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
        <span class="text">Nueva sanción</span>
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
                <th>Colaborador</th>
                <th>Motivo</th>
                <th>Fecha</th>
                <th>Días</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(sancion, index) in sanciones" v-bind:key="sancion.id">
                <td>{{ index + 1 }}</td>
                <td>{{ sancion.nombre + " " + sancion.apellido }}</td>
                <td>{{ sancion.motivo }}</td>
                <td>{{ sancion.created_at | moment("DD/MM/YYYY") }}</td>
                <td>{{ sancion.dias_sancion }}</td>
                <td class="text-center">
                  <button
                    @click="abrirModal('editar', sancion)"
                    data-toggle="tooltip"
                    title="Editar Reunión"
                    class="btn btn-warning btn-circle btn-sm"
                  >
                    <fa icon="edit" />
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
              {{ opcion_modal == 1 ? "Nueva" : "Editar" }} sanción
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
                    <label for="exampleFormControlSelect1">Colaborador</label>
                    <select
                      v-model="formulario.id_colaborador"
                      :class="[
                        'form-control',
                        errores.id_colaborador ? 'is-invalid' : '',
                      ]"
                      id="exampleFormControlSelect1"
                    >
                      <option
                        v-for="colaborador in colaboradores"
                        v-bind:value="colaborador.id"
                        v-bind:key="colaborador.id"
                      >
                        {{ colaborador.nombre + " " + colaborador.apellido }}
                      </option>
                    </select>
                    <div v-if="errores.id_colaborador" class="invalid-feedback">
                      {{ errores.id_colaborador[0] }}
                    </div>
                  </div>
                  <div class="col-12 form-group">
                    <label for="nombre">Motivo:</label>
                    <input
                      type="text"
                      :class="[
                        'form-control',
                        errores.motivo ? 'is-invalid' : '',
                      ]"
                      v-model="formulario.motivo"
                      id="nombre"
                    />
                    <div v-if="errores.motivo" class="invalid-feedback">
                      {{ errores.motivo[0] }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row">
                  <div class="col-6 form-group">
                    <label for="apellido">Dias sanción:</label>
                    <input
                      type="number"
                      min="1"
                      max="10"
                      :class="[
                        'form-control',
                        errores.dias_sancion ? 'is-invalid' : '',
                      ]"
                      v-model="formulario.dias_sancion"
                      id="apellido"
                    />
                    <div v-if="errores.dias_sancion" class="invalid-feedback">
                      {{ errores.dias_sancion[0] }}
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
              v-if="opcion_modal == 1"
              @click="registrarSancion()"
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
            <button v-else @click="editarSancion()" class="btn btn-warning">
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
      sanciones: [],
      colaboradores: [],
      loader: false,
      formulario: {},
      errores: {},
      opcion_modal: 1,
    };
  },

  mounted() {
    this.listarSanciones();
    this.iniciarFormulario();
    this.listarColaboradores();
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
        id: "",
        id_colaborador: "",
        motivo: "",
        dias_sancion: "",
      };
    },

    mostrarAlerta() {
      var mensaje = "Sanción registrada correctamente";
      if (this.opcion_modal == 1) {
        mensaje = "Sanción registrada correctamente";
      } else {
        mensaje = "Sanción actualizada correctamente";
      }
      this.$swal.fire({
        icon: "success",
        title: mensaje,
        showConfirmButton: false,
        timer: 1500,
      });
    },

    abrirModal(tipo_accion, sancion) {
      this.errores = {};
      if (tipo_accion == "registrar") {
        this.opcion_modal = 1;
        this.iniciarFormulario();
      } else {
        this.opcion_modal = 2;
        this.formulario = sancion;
      }
      $("#registerModal").modal("show");
    },

    listarSanciones: async function () {
      axios
        .get("/sanciones/list")
        .then((response) => {
          this.sanciones = response.data.data;
          this.iniciarTabla();
        })
        .catch((error) => {
          console.log(error);
        });
    },

    listarColaboradores: function () {
      axios
        .get("/colaboradores/list")
        .then((response) => {
          this.colaboradores = response.data.data;
          this.colaboradores = this.colaboradores.filter((colaborador) => {
            if (colaborador.estado != "deshabilitado") {
              return colaborador;
            }
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },

    registrarSancion: function () {
      this.loader = true;
      const formdata = new FormData();
      formdata.append("id_colaborador", this.formulario.id_colaborador);
      formdata.append("motivo", this.formulario.motivo);
      formdata.append("dias_sancion", this.formulario.dias_sancion);

      axios
        .post("/sanciones/store", formdata)
        .then((response) => {
          this.iniciarFormulario();
          this.mostrarAlerta();
          this.listarSanciones();
          this.iniciarTabla();
          this.loader = false;
        })
        .catch((error) => {
          this.errores = error.response.data.errors;
          this.loader = false;
        });
    },

    editarSancion: function () {
      const formdata = new FormData();
      formdata.append("id", this.formulario.id);
      formdata.append("id_colaborador", this.formulario.id_colaborador);
      formdata.append("motivo", this.formulario.motivo);
      formdata.append("dias_sancion", this.formulario.dias_sancion);
      axios
        .post("/sanciones/update", formdata)
        .then((response) => {
          this.iniciarFormulario();
          this.mostrarAlerta();
          this.listarSanciones();
        })
        .catch((error) => {
          this.errores = error.response.data.errors;
          console.log(error.response.data);
        });
    },
  },
};
</script>

<style>
</style>
