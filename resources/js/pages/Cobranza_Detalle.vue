<template>
  <div>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Colabodores a cobrar</h1>
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
              <tr v-for="(pago, index) in pagos" v-bind:key="index">
                <td>{{ index + 1 }}</td>
                <td v-if="pago.estado">
                  {{ pago.updated_at | moment("DD/MM/YYYY") }}
                </td>
                <td v-else>Pendiente</td>
                <td>{{ pago.nombre + " " + pago.apellido }}</td>
                <td>{{ pago.monto }}</td>
                <td>{{ pago.estado == 0 ? "Pendiente" : "Cancelado" }}</td>
                <td v-if="pago.estado == 0" class="text-center">
                  <button
                    @click="cancelarPago(pago.id, pago.nombre, pago.apellido)"
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
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      loader: false,
      pagos: [],
    };
  },

  mounted() {
    this.listarDetallePagos();
  },

  methods: {
    iniciarTabla(response) {
      this.$nextTick(() => {
        $("#dataTable").DataTable();
      });
    },

    cancelarPago(id, name, last_name) {
      this.$swal
        .fire({
          icon: "warning",
          title: "Cancelar pago de " + name + " " + last_name,
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Si, cancelar pago!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios
              .post("/cobranza/update/detail/" + id)
              .then((response) => {
                this.listarDetallePagos();
                this.$swal.fire({
                  icon: "success",
                  title: 'Pago realizado',
                  showConfirmButton: false,
                  timer: 1500,
                });
              })
              .catch((error) => {
                console.log(error);
              });
          }
        });
    },

    listarDetallePagos: function () {
      axios
        .get("/cobranza/" + this.id_pago + "/list")
        .then((response) => {
          this.pagos = response.data.data;
          this.iniciarTabla();
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style>
</style>
