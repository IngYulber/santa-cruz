<template>
  <div>
    <h1 class="h3 mb-2 text-gray-800">Reportes</h1>
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-xl-4 col-md-8 col-sm-10">
            <p class="font-weight-bold">Grupos de reporte</p>
            <div class="row">
              <div class="col-6 mt-2" @click="cambiarModo('deudas')">
                <div
                  :class="[
                    'card card-body text-center',
                    modo_actual == 'deudas'
                      ? 'bg-primary text-white'
                      : 'bg-light',
                  ]"
                >
                  <fa icon="receipt" style="font-size: 2rem" />
                  <p class="mt-3">Deudas</p>
                </div>
              </div>
              <!-- <div class="col-6 mt-2" @click="cambiarModo('colaboradores')">
                <div
                  :class="[
                    'card card-body text-center',
                    modo_actual == 'colaboradores'
                      ? 'bg-primary text-white'
                      : 'bg-light',
                  ]"
                >
                  <fa icon="users" style="font-size: 2rem" />
                  <p class="mt-3">Colaboradores</p>
                </div>
              </div> -->
              <!-- <div class="col-6 mt-2" @click="cambiarModo('reuniones')">
                <div
                  :class="[
                    'card card-body text-center',
                    modo_actual == 'reuniones'
                      ? 'bg-primary text-white'
                      : 'bg-light',
                  ]"
                >
                  <fa icon="handshake" style="font-size: 2rem" />
                  <p class="mt-3">Reuniones</p>
                </div>
              </div>
              <div class="col-6 mt-2" @click="cambiarModo('sanciones')">
                <div
                  :class="[
                    'card card-body text-center',
                    modo_actual == 'sanciones'
                      ? 'bg-primary text-white'
                      : 'bg-light',
                  ]"
                >
                  <fa icon="ban" style="font-size: 2rem" />
                  <p class="mt-3">Sanciones</p>
                </div>
              </div> -->
            </div>
          </div>
          <div class="col-xl-4 col-md-8 col-sm-10">
            <p class="font-weight-bold">Tipo de reporte</p>
            <div class="form-group" v-show="reportes_disponibles">
              <select class="form-control" v-model="reporte_seleccionado">
                <option
                  v-for="reporte in reportes_disponibles"
                  v-bind:value="reporte"
                  v-bind:key="reporte"
                >
                  {{ reporte }}
                </option>
              </select>
            </div>
            <div class="form-group" v-show="select_colaborador">
              <label for="exampleFormControlSelect1">Colaborador</label>
              <select class="form-control" v-model="colaborador_seleccionado">
                <option
                  v-for="colaborador in colaboradores"
                  v-bind:value="colaborador.id"
                  v-bind:key="colaborador.id"
                >
                  {{ colaborador.label }}
                </option>
              </select>
            </div>
          </div>
          <div class="col-xl-4 col-md-8 col-sm-10">
            <p class="font-weight-bold">Fecha y Formato</p>
            <div v-show="reporte_seleccionado">
              <div>
                <p class="text-center">Desde</p>
                <input
                  type="date"
                  v-model="filtro_desde"
                  class="form-control"
                />
                <p class="mt-2 text-center">Hasta</p>
                <input
                  type="date"
                  v-model="filtro_hasta"
                  class="form-control"
                />
              </div>
              <div class="mt-5">
                <span>Generar en:</span>
                <button class="btn btn-light ml-3" @click="reportePDF()">
                  <fa icon="file-pdf" style="font-size: 1.5rem" />
                </button>
                <!-- <button class="btn btn-light">
                  <fa icon="file-excel" style="font-size: 1.5rem" />
                </button> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { jsPDF } from "jspdf";
export default {
  data() {
    return {
      modo_actual: "deudas",
      reportes_disponibles: [
        "Total por deudas pendientes",
        "Deudas por colaborador",
        "Historial de deudas por colaborador",
      ],
      reporte_seleccionado: "Total por deudas pendientes",
      reportes_deudas: [
        "Total por deudas pendientes",
        "Deudas por colaborador",
        "Historial de deudas por colaborador",
      ],
      reportes_colaboradores: ["ds", "dasd"],
      reportes_reuniones: [
        "Asistencias generales",
        "Asistencias por colaborador",
      ],
      reportes_sanciones: [
        "Colaboradores sancionados",
        "Sanciones por colaborador",
      ],

      filtro_desde: "",
      filtro_hasta: "",
      colaboradores: [],
      colaborador_seleccionado: "",
      select_colaborador: false,
    };
  },

  mounted() {
    this.listarColaboradores();
  },

  methods: {
    cambiarModo(modo) {
      this.modo_actual = modo;
      switch (modo) {
        case "deudas":
          this.reportes_disponibles = this.reportes_deudas;
          this.reporte_seleccionado = this.reportes_deudas[0];
          break;
        case "colaboradores":
          this.reportes_disponibles = this.reportes_colaboradores;
          this.reporte_seleccionado = this.reportes_colaboradores[0];
          break;
        case "reuniones":
          this.reportes_disponibles = this.reportes_reuniones;
          this.reporte_seleccionado = this.reportes_reuniones[0];
          break;
        case "sanciones":
          this.reportes_disponibles = this.reportes_sanciones;
          this.reporte_seleccionado = this.reportes_sanciones[0];
          break;
        default:
          break;
      }
    },

    createHeaders(keys) {
      var result = [];
      for (var i = 0; i < keys.length; i += 1) {
        result.push({
          id: keys[i].value,
          name: keys[i].value,
          prompt: keys[i].value,
          width: keys[i].width,
          align: "center",
          padding: 0,
        });
      }
      return result;
    },
    reportePDF() {
      switch (this.reporte_seleccionado) {
        case "Total por deudas pendientes":
          this.reporteTotalDeudasPendiente();
          break;

        case "Deudas por colaborador":
          this.reporteDeudasColaborador();
          break;

        case "Historial de deudas por colaborador":
          this.reporteHistorialDeudasColaborador();
          break;

        default:
          alert("No se encuentra disponible");
          break;
      }
    },

    reporteTotalDeudasPendiente() {
      var reporte = jsPDF();
      const formdata = new FormData();

      formdata.append("reporte", this.reporte_seleccionado);
      formdata.append("desde", this.filtro_desde);
      formdata.append("hasta", this.filtro_hasta);
      axios
        .post("/reportes/make", formdata)
        .then((response) => {
          var total_cobrar = 0;
          var datos = response.data.data.map(
            ({ id, descripcion, cuentas, total, fecha_fin }) => ({
              Codigo: id.toString(),
              "Descripción del cobro": descripcion,
              Cuentas: cuentas.toString(),
              "F. vencimiento": fecha_fin,
              Total: total,
            })
          );
          response.data.data.map((element) => {
            total_cobrar += Number(element.total);
          });
          reporte.setFont("helvetica", "bold");
          reporte.addImage("../../images/logo.png", "PNG", 10, 9, 40, 18);
          reporte.text("Total por Deudas Pendientes", 65, 20);
          var headers = this.createHeaders([
            { value: "Codigo", width: 30 },
            { value: "Descripción del cobro", width: 110 },
            { value: "Cuentas", width: 35 },
            { value: "F. vencimiento", width: 50 },
            { value: "Total", width: 30 },
          ]);

          reporte.table(10, 45, datos, headers, {
            printHeaders: true,
            headerBackgroundColor: "#4393FB",
          });
          reporte.text(
            "Total a cobrar:       S/." + total_cobrar + ".00",
            145,
            40
          );
          reporte.save("TOTAL-DEUDAS-PENDIENTES.pdf");
        })
        .catch((error) => {
          console.log(error);
        });
    },

    reporteDeudasColaborador() {
      var reporte = jsPDF();
      const formdata = new FormData();
      if (this.colaborador_seleccionado == "") {
        alert("Seleccione un colaborador");
        return false;
      }
      formdata.append("reporte", this.reporte_seleccionado);
      formdata.append("desde", this.filtro_desde);
      formdata.append("hasta", this.filtro_hasta);
      formdata.append("colaborador", this.colaborador_seleccionado);
      axios
        .post("/reportes/make", formdata)
        .then((response) => {
          if (response.data.data.length == 0) {
            alert("No se tienen registros");
            return false;
          }
          const colaborador_reporte = this.colaboradores.filter((element) => {
            if (element.id == this.colaborador_seleccionado) {
              return element;
            }
          });
          var total_cobrar = 0;
          var datos = response.data.data.map(
            ({ apellido, descripcion, fecha_fin, id, monto, nombre }) => ({
              "N°": id.toString(),
              "Descripción del cobro": descripcion,
              Estado: "Pendiente",
              "F. vencimiento": fecha_fin,
              Monto: monto,
            })
          );
          response.data.data.map((element) => {
            total_cobrar += Number(element.monto);
          });
          reporte.setFont("helvetica", "bold");
          reporte.addImage("../../images/logo.png", "PNG", 10, 9, 40, 18);
          reporte.text("Deudas Pendientes por Colaborador", 70, 20);
          var headers = this.createHeaders([
            { value: "N°", width: 15 },
            { value: "Descripción del cobro", width: 120 },
            { value: "Estado", width: 40 },
            { value: "F. vencimiento", width: 50 },
            { value: "Monto", width: 30 },
          ]);
          reporte.table(10, 45, datos, headers, {
            printHeaders: true,
            headerBackgroundColor: "#4393FB",
          });
          reporte.text("Colaborador: " + colaborador_reporte[0].label, 45, 40);
          reporte.text(
            "Total a cobrar:       S/." + total_cobrar + ".00",
            145,
            40
          );
          reporte.save("Deudas-" + colaborador_reporte[0].label + ".pdf");
        })
        .catch((error) => {
          console.log(error);
        });
    },

    reporteHistorialDeudasColaborador() {
      var reporte = jsPDF();
      const formdata = new FormData();
      if (this.colaborador_seleccionado == "") {
        alert("Seleccione un colaborador");
        return false;
      }
      const colaborador_reporte = this.colaboradores.filter((element) => {
        if (element.id == this.colaborador_seleccionado) {
          return element;
        }
      });
      formdata.append("reporte", this.reporte_seleccionado);
      formdata.append("desde", this.filtro_desde);
      formdata.append("hasta", this.filtro_hasta);
      formdata.append("colaborador", this.colaborador_seleccionado);
      axios
        .post("/reportes/make", formdata)
        .then((response) => {
          if (response.data.data.length == 0) {
            alert("No se tienen registros");
            return false;
          }
          var total_cobrar = 0;
          var datos = response.data.data.map(
            ({ id, descripcion, estado, fecha_fin, monto }) => ({
              "N°": id.toString(),
              "Descripción del cobro": descripcion,
              Estado: estado ? "Cancelado" : "Pendiente",
              "F. vencimiento": fecha_fin,
              Monto: monto,
            })
          );
          response.data.data.map((element) => {
            total_cobrar += Number(element.monto);
          });
          reporte.setFont("helvetica", "bold");
          reporte.addImage("../../images/logo.png", "PNG", 10, 9, 40, 18);
          reporte.text("Historial de Deudas por Colaborador", 60, 20);
          var headers = this.createHeaders([
            { value: "N°", width: 15 },
            { value: "Descripción del cobro", width: 120 },
            { value: "Estado", width: 40 },
            { value: "F. vencimiento", width: 50 },
            { value: "Monto", width: 30 },
          ]);
          reporte.table(10, 45, datos, headers, {
            printHeaders: true,
            headerBackgroundColor: "#4393FB",
          });
          reporte.text(
            "Total a generar:       S/." + total_cobrar + ".00",
            145,
            40
          );
          reporte.text("Colaborador: " + colaborador_reporte[0].label, 45, 40);
          reporte.save(
            "Historial-Deudas-" + colaborador_reporte[0].label + ".pdf"
          );
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
          this.colaboradores = this.colaboradores.map((colabordor) => ({
            id: colabordor.id,
            label: colabordor.nombre + " " + colabordor.apellido,
          }));
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  watch: {
    reporte_seleccionado(newValue, oldValue) {
      switch (newValue) {
        case "Sanciones por colaborador":
          this.select_colaborador = true;
          break;
        case "Asistencias por colaborador":
          this.select_colaborador = true;
          break;
        case "Deudas por colaborador":
          this.select_colaborador = true;
          break;

        case "Historial de deudas por colaborador":
          this.select_colaborador = true;
          break;
        default:
          this.select_colaborador = false;
          break;
      }
    },
  },
};
</script>
