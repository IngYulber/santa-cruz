<template>
  <div v-if="loading">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Panel de indicadores</h1>
      <a
        href="/reportes"
        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
      >
        <fa icon="download" /> Generar Reporte
      </a>
    </div>

    <!-- Content Row -->
    <div class="row">
      <Card
        :kpi="'% CUENTAS A COBRAR'"
        :title="por_cuentas_cobrar + '% de cuentas a cobrar'"
        :detail="cuentas_cobrar + ' de ' + total_cuentas + ' cuentas en total'"
        :color="'primary'"
      />
      <Card
        :kpi="'% DEUDAS VENCIDAS'"
        :title="por_deudas_vencidas + '% de deudas vencidas'"
        :detail="deudas_vencidas + ' deudas vencidas'"
        :color="'primary'"
      />
      <Card
        :kpi="'TOTAL A COBRAR'"
        :title="'S/. ' + monto_cobrar + ' en deudas pendientes'"
        :detail="'de ' + cuentas_cobrar + ' cuentas por cobrar'"
        :color="'success'"
      />
      <Card
        :kpi="'% CUENTAS NUEVAS'"
        :title="'30% Cuentas nuevas este mes'"
        :detail="'10 cuentas nuevas'"
        :color="'success'"
      />
    </div>

    <!-- Content Row -->
    <div class="row">
      <!-- Area Chart -->
      <div class="col-xl-7 col-lg-7">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row">
            <h6 class="m-0 font-weight-bold text-primary">
              Cuentas pendientes por deudas
            </h6>
          </div>
          <!-- Card Body -->
          <div class="card-body">
            <BarChart :chartData="datos_chart" />
          </div>
        </div>
      </div>

      <!-- Pie Chart -->
      <div class="col-xl-5 col-lg-5">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex flex-row">
            <h6 class="m-0 font-weight-bold text-primary">
              Cuentas pendientes por deudas
            </h6>
          </div>
          <div class="card-body">
            <PieChart :chartData="datos_pie" />
          </div>
        </div>
      </div>
    </div>

  </div>

  <div v-else>
    <div class="d-flex align-items-center">
      <strong>Cargando información...</strong>
      <div
        class="spinner-border mx-auto"
        role="status"
        aria-hidden="true"
      ></div>
    </div>
  </div>
</template>

<script>
import Card from "../components/Card.vue";
import BarChart from "../components/BarChart.vue";
import PieChart from "../components/PieChart.vue";
export default {
  components: {
    Card,
    BarChart,
    PieChart,
  },
  data() {
    return {
      por_cuentas_cobrar: 0,
      cuentas_cobrar: 0,
      total_cuentas: 0,
      monto_cobrar: 0,
      deudas_vencidas: 0,
      por_deudas_vencidas: 0,
      datos_chart: {},
      loading: false,
      tipos_reporte: ["Deudas por usuario", "Deudas por mes"],
      reporte_seleccionado: "Deudas por usuario"
    };
  },
  mounted() {
    this.listarKpis();
  },

  methods: {
    listarKpis: function () {
      axios
        .get("/utils/kpis")
        .then((response) => {
          this.total_cuentas = response.data.totalCobrar;
          this.cuentas_cobrar = response.data.cuentasCobrar;
          this.por_cuentas_cobrar = Math.round(
            (this.cuentas_cobrar * 100) / this.total_cuentas
          );
          this.monto_cobrar = Intl.NumberFormat("es-PE").format(
            response.data.montoCobrar
          );
          this.deudas_vencidas = response.data.porDeudasVencidas;
          this.por_deudas_vencidas = Math.round(
            (this.deudas_vencidas * 100) / this.total_cuentas
          );
          this.datos_chart = {
            labels: response.data.cuentas_deudas.map(
              (item) => item.descripcion
            ),
            datasets: [
              {
                label: "Total de cuentas a cobrar por deuda",
                data: response.data.cuentas_deudas.map((item) => item.total),
                backgroundColor: "#4c51bf",
                borderColor: "#4c51bf",
                borderWidth: 1,
              },
            ],
          };
          this.datos_pie = {
            labels: response.data.cuentas_deudas.map(
              (item) => item.descripcion
            ),
            datasets: [
              {
                label: "Cuentas pendientes por deudas",
                backgroundColor: ["#6281C8", "#334672", "#A3B5DE", "#4c51bf"],
                data: response.data.cuentas_deudas.map((item) => item.total),
              },
            ],
          };
          this.loading = true;
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
