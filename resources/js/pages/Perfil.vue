<template>
  <div>
    <section>
      <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
          <div class="card">
            <div class="card-body">
              <div class="user-avatar-section">
                <div class="d-flex align-items-center flex-column">
                  <img
                    class="img-fluid rounded mt-1 mb-2"
                    src="https://cdn-icons-png.flaticon.com/512/506/506185.png"
                    height="110"
                    width="110"
                    alt="User avatar"
                  />
                  <div class="user-info text-center">
                    <h4></h4>
                    <span class="badge bg-light-secondary"></span>
                    <span class="badge bg-light-secondary"></span>
                  </div>
                </div>
              </div>

              <h4 class="fw-bolder border-bottom pb-50 mb-1">Detalles</h4>
              <div class="info-container">
                <ul class="list-unstyled">
                  <li class="mt-3">
                    <span class="fw-bolder me-25">Nombre:</span>
                    <span>{{ user.nombre }}</span>
                  </li>
                  <li class="mt-3">
                    <span class="fw-bolder me-25">Apellidos:</span>
                    <span>{{ user.apellido }}</span>
                  </li>
                  <li class="mt-3">
                    <span class="fw-bolder me-25">Numero de documento:</span>
                    <span>{{ user.dni }}</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
          <ul class="nav nav-pills mb-2">
            <li class="nav-item">
              <a class="nav-link" :class="opcion_menu == 0 ? 'active' : ''">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="14"
                  height="14"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-user font-medium-3 me-50"
                >
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                  <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span class="fw-bold" @click="cambiarMenu(0)">Cuenta</span></a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" :class="opcion_menu == 1 ? 'active' : ''">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="14"
                  height="14"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-lock font-medium-3 me-50"
                >
                  <rect
                    x="3"
                    y="11"
                    width="18"
                    height="11"
                    rx="2"
                    ry="2"
                  ></rect>
                  <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <span class="fw-bold" @click="cambiarMenu(1)">Seguridad</span>
              </a>
            </li>
          </ul>

          <div class="row">
            <div class="col-12">
              <div v-show="opcion_menu == 0" class="card border-primary">
                <h4 class="card-header">Editar Perfil</h4>
                <div class="card-body">
                  <div>
                    <div class="row">
                      <div class="mb-1 col-md-6">
                        <label class="form-label" for="name">Nombre:</label>
                        <div class="input-group input-group-merge">
                          <input
                            :class="[
                              'form-control',
                              errores.nombre ? 'is-invalid' : '',
                            ]"
                            type="text"
                            v-model="user.nombre"
                            :disabled="!nuevosCambios"
                            placehconf_paser="············"
                          />
                          <div v-if="errores.nombre" class="invalid-feedback">
                            {{ errores.nombre[0] }}
                          </div>
                        </div>
                      </div>

                      <div class="mb-1 col-md-6">
                        <label class="form-label" for="lastname"
                          >Apellido:</label
                        >
                        <div class="input-group input-group-merge">
                          <input
                            :class="[
                              'form-control',
                              errores.apellido ? 'is-invalid' : '',
                            ]"
                            type="text"
                            v-model="user.apellido"
                            :disabled="!nuevosCambios"
                            placehconf_paser="············"
                          />
                          <div v-if="errores.apellido" class="invalid-feedback">
                            {{ errores.apellido[0] }}
                          </div>
                        </div>
                      </div>

                      <div class="mb-1 col-md-6">
                        <label class="form-label" for="email">Dni:</label>
                        <div class="input-group input-group-merge">
                          <input
                            :class="[
                              'form-control',
                              errores.dni ? 'is-invalid' : '',
                            ]"
                            type="email"
                            v-model="user.dni"
                            :disabled="!nuevosCambios"
                          />
                          <div v-if="errores.dni" class="invalid-feedback">
                            {{ errores.dni[0] }}
                          </div>
                        </div>
                      </div>
                      <div class="mt-3 col-md-12">
                        <div class="d-flex justify-content-end">
                          <button
                            v-if="nuevosCambios"
                            @click="cambiarFormulario(false)"
                            class="btn btn-secondary"
                          >
                            Cancelar
                          </button>
                          <button
                            v-if="nuevosCambios"
                            @click="actualizarPerfil()"
                            class="
                              btn btn-primary
                              ml-1
                              waves-effect waves-float waves-light
                            "
                          >
                            Guardar Cambios
                          </button>
                          <button
                            v-else
                            @click="cambiarFormulario(true)"
                            class="
                              btn btn-primary
                              ml-1
                              waves-effect waves-float waves-light
                            "
                          >
                            Editar perfil
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div v-show="opcion_menu == 1" class="card border-primary">
                <h4 class="card-header">Cambiar Contraseña</h4>
                <div class="card-body">
                  <div>
                    <div class="row">
                      <div class="mb-2 col-md-6 form-password-toggle">
                        <label class="form-label" for="newPassword"
                          >Nueva Contraseña</label
                        >
                        <div
                          class="
                            input-group input-group-merge
                            form-password-toggle
                          "
                        >
                          <input
                            :class="[
                              'form-control',
                              errores.password ? 'is-invalid' : '',
                            ]"
                            :type="pass_1 ? 'password' : 'text'"
                            v-model="contra_1"
                          />
                          <span
                            class="input-group-text cursor-pointer"
                            @click="mostrarContrase(1)"
                          >
                            <fa :icon="pass_1 ? 'eye' : 'eye-slash'" />
                          </span>
                          <div v-if="errores.password" class="invalid-feedback">
                            {{ errores.password[0] }}
                          </div>
                        </div>
                      </div>

                      <div class="mb-2 col-md-6 form-password-toggle">
                        <label class="form-label" for="confirmPassword"
                          >Confirmar Nueva Contraseña</label
                        >
                        <div class="input-group input-group-merge">
                          <input
                            class="form-control"
                            :type="pass_2 ? 'password' : 'text'"
                            v-model="contra_2"
                          />
                          <span
                            class="input-group-text cursor-pointer"
                            @click="mostrarContrase(2)"
                          >
                            <fa :icon="pass_2 ? 'eye' : 'eye-slash'"
                          /></span>
                        </div>
                      </div>

                      <div class="col-md-12 mt-2">
                        Mínimo 8 caracteres de largo
                      </div>

                      <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                          <button
                            @click="cambiarContra()"
                            type="button"
                            class="
                              btn btn-primary
                              waves-effect waves-float waves-light
                            "
                          >
                            Cambiar Contraseña
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  data() {
    return {
      nuevosCambios: false,
      opcion_menu: 0,
      pass_1: true,
      errores: {},
      pass_2: true,
      contra_1: "",
      contra_2: "",
      user: {
        nombre: "",
        apellido: "",
        dni: "",
        password: "",
      },
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    async getData() {
      axios
        .get("/perfil/info")
        .then((response) => {
          this.user = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
      axios.p;
    },

    async actualizarPerfil() {
      const formdata = new FormData();
      formdata.append("nombre", this.user.nombre);
      formdata.append("apellido", this.user.apellido);
      formdata.append("dni", this.user.dni);
      axios
        .post("/perfil/update", formdata)
        .then((response) => {
          this.$swal.fire({
            icon: "success",
            title: "Datos actualizados",
            showConfirmButton: false,
            timer: 1500,
          });
          this.nuevosCambios = false;
          this.errores = {};
        })
        .catch((error) => {
          console.log(error);
          this.errores = error.response.data.errors;
        });
    },

    async cambiarContra() {
      if (this.contra_1 != this.contra_2) {
        alert("Las contraseñas no son iguales");
        return;
      }

      const formdata = new FormData();
      formdata.append("password", this.contra_1);
      formdata.append("password2", this.contra_2);

      axios
        .post("/perfil/update-password", formdata)
        .then((response) => {
          this.$swal.fire({
            icon: "success",
            title: "Contraseña actualizada",
            showConfirmButton: false,
            timer: 1500,
          });
          this.contra_1 = "";
          this.contra_2 = "";
        })
        .catch((error) => {
          this.errores = error.response.data.errors;
          console.log(error);
        });
    },

    cambiarFormulario(estado) {
      this.nuevosCambios = estado;
    },
    cambiarMenu(opcion) {
      this.opcion_menu = opcion;
    },

    mostrarContrase(opcion) {
      if (opcion == 1) {
        this.pass_1 = this.pass_1 ? false : true;
      } else {
        this.pass_2 = this.pass_2 ? false : true;
      }
    },
  },
};
</script>

<style>
</style>
