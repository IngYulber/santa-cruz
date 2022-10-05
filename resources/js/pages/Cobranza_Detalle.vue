<template>
  <div>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Detalle del monto a cobrar</h1>
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
                <th>Fecha de pago</th>
                <th>Colaborador</th>
                <th>Monto</th>
                <th>Estado</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="pago in pagos" v-bind:key="pago.id">
                <td>{{ pago.id }}</td>
                <td v-if="pago.estado">{{ pago.fecha_inicio | moment("DD/MM/YYYY") }}</td>
                <td v-else>******</td>
                <td>{{ pago.nombre +' '+pago.apellido}}</td>
                <td>{{ pago.monto }}</td>
                <td>{{ pago.estado == 0 ? 'Pendiente':'Cancelado' }}</td>
                <td class="text-center">
                  <button
                    data-toggle="tooltip"
                    title="Registrar pago"
                    class="btn btn-success btn-circle btn-sm"
                  >
                    <fa icon="credit-card" />
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    id_pago: {
      type: String,
      required: true,
    },
  },
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
    this.listarDetallePagos();
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
        fecha_inicio: "",
        fecha_fin: "",
        monto: "",
      };
    },

    listarDetallePagos: function () {
      axios
        .get("/cobranza/"+this.id_pago+"/list")
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
