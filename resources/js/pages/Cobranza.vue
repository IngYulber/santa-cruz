<template>
  <div>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Cobranza</h1>
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
        <span class="text">Nuevo monto a cobrar</span>
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
                <th>Descripción</th>
                <th>Fecha inicio</th>
                <th>Fecha fin</th>
                <th>Monto</th>
                <th>Estado</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(pago, index) in pagos" v-bind:key="pago.id" :class="[pago.estado == 'Deudas pendientes' ? 'bg-red' : 'bg-green' ]">
                <td>{{ index+1 }}</td>
                <td>{{ pago.descripcion }}</td>
                <td>{{ pago.fecha_inicio | moment("DD/MM/YYYY") }}</td>
                <td>{{ pago.fecha_fin | moment("DD/MM/YYYY") }}</td>
                <td>{{ pago.monto }}</td>
                <td>{{ (pago.total2-pago.total) +'/'+pago.total2 }}</td>
                <td class="text-center">
                  <button
                    @click="vistaAsistencia(pago.id)"
                    data-toggle="tooltip"
                    title="Visualizar detalle del cobro"
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
              {{ opcion_modal == 1 ? "Registrar" : "Editar" }} monto a cobrar
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
                    <label for="fecha_inicio">Descripción:</label>
                    <input
                      type="text"
                      :class="[
                        'form-control',
                        errores.descripcion ? 'is-invalid' : '',
                      ]"
                      v-model="formulario.descripcion"
                      id="descripcion"
                    />
                    <div v-if="errores.descripcion" class="invalid-feedback">
                      {{ errores.descripcion[0] }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row">
                  <div class="col-12 form-group">
                    <label for="fecha_inicio">Fecha inicio:</label>
                    <input
                      type="date"
                      :class="[
                        'form-control',
                        errores.fecha_inicio ? 'is-invalid' : '',
                      ]"
                      v-model="formulario.fecha_inicio"
                      id="fecha_inicio"
                    />
                    <div v-if="errores.fecha_inicio" class="invalid-feedback">
                      {{ errores.fecha_inicio[0] }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row">
                  <div class="col-12 form-group">
                    <label for="fecha_fin">Fecha fin:</label>
                    <input
                      type="date"
                      :class="[
                        'form-control',
                        errores.fecha_fin ? 'is-invalid' : '',
                      ]"
                      v-model="formulario.fecha_fin"
                      id="fecha_fin"
                    />
                    <div v-if="errores.fecha_fin" class="invalid-feedback">
                      {{ errores.fecha_fin[0] }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row">
                  <div class="col-12 form-group">
                    <label for="monto">Monto:</label>
                    <input
                      type="number"
                      :class="[
                        'form-control',
                        errores.monto ? 'is-invalid' : '',
                      ]"
                      v-model="formulario.monto"
                      id="monto"
                    />
                    <div v-if="errores.monto" class="invalid-feedback">
                      {{ errores.monto[0] }}
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
              @click="registrarPago()"
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
      pagos: [],
      loader: false,
      formulario: {},
      errores: {},
      opcion_modal: 1,
    };
  },

  mounted() {
    this.listarPagos();
    this.iniciarFormulario();
  },

  methods: {
    iniciarTabla(response) {
      this.$nextTick(() => {
        $("#dataTable").DataTable();
      });
    },

    vistaAsistencia(id) {
      window.location.href = "cobranza/" + id;
    },

    iniciarFormulario() {
      $("#registerModal").modal("hide");
      this.formulario = {
        id: "",
        descripcion: "",
        fecha_inicio: "",
        fecha_fin: "",
        monto: "",
      };
    },

    mostrarAlerta() {
      var mensaje = "Monto a pagar registrado correctamente";
      if (this.opcion_modal == 1) {
        mensaje = "Monto a pagar registrado correctamente";
      } else if (this.opcion_modal == 2) {
        mensaje = "Monto a pagar actualizado correctamente";
      } else if (this.opcion_modal == 3) {
        mensaje = "Monto a pagar activado correctamente";
      } else {
        mensaje = "Monto a pagar desactivado correctamente";
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

    listarPagos: function () {
      axios
        .get("/cobranza/list")
        .then((response) => {
          this.pagos = response.data.data;
          this.iniciarTabla();
        })
        .catch((error) => {
          console.log(error);
        });
    },

    registrarPago: function () {
      const formdata = new FormData();
      formdata.append("descripcion", this.formulario.descripcion);
      formdata.append("fecha_inicio", this.formulario.fecha_inicio);
      formdata.append("fecha_fin", this.formulario.fecha_fin);
      formdata.append("monto", this.formulario.monto);

      axios
        .post("/cobranza/store", formdata)
        .then((response) => {
          this.iniciarFormulario();
          this.listarPagos();
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
