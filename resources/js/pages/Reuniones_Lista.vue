<template>
  <div>
    <!-- Page Heading -->
    <h1 v-if="loader" class="h3 mb-2 text-gray-800">
      Asistencia del {{ asistencias[0].created_at | moment("DD/MM/YYYY") }}
    </h1>
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
                <th>Colaborador</th>
                <th class="text-center">Asistencia</th>
                <th class="text-center">Falta</th>
                <th class="text-center">Tardanza</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(asistencia, index) in asistencias" v-bind:key="index">
                <td>{{ index + 1 }}</td>
                <td>{{ asistencia.nombre + " " + asistencia.apellido }}</td>
                <td
                  v-if="asistencia.estado != 'asistio'"
                  @click="marcarAsistencia(asistencia.id, 'asistio')"
                />
                <td v-else class="text-center text-success"><fa icon="check" /></td>
                <td
                  v-if="asistencia.estado != 'falto'"
                  @click="marcarAsistencia(asistencia.id, 'falto')"
                />
                <td v-else class="text-center text-danger"><fa icon="check" /></td>
                <td
                  v-if="asistencia.estado != 'tardanza'"
                  @click="marcarAsistencia(asistencia.id, 'tardanza')"
                />
                <td v-else class="text-center text-warning"><fa icon="check" /></td>
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
    id_reunion: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      loader: false,
      asistencias: [],
    };
  },

  mounted() {
    this.listarAsistencias();
  },

  methods: {
    iniciarTabla(response) {
      this.$nextTick(() => {
        $("#dataTable").DataTable();
      });
    },

    marcarAsistencia(id, opcion) {
      const formdata = new FormData();
      formdata.append('estado', opcion)
      axios
        .post("/reuniones/update/detail/" + id, formdata)
        .then((response) => {
          this.listarAsistencias();
        })
        .catch((error) => {
          console.log(error);
        });
    },

    listarAsistencias: function () {
      axios
        .get("/reuniones/" + this.id_reunion + "/list")
        .then((response) => {
          this.asistencias = response.data.data;
          this.iniciarTabla();
          this.loader = true;
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
