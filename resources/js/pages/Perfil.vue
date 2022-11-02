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
                    <span class="fw-bolder me-25"
                      >Nombre:</span
                    >
                    <span>{{user.nombre}}</span>
                  </li>
                  <li class="mt-3">
                    <span class="fw-bolder  me-25"
                      >Apellidos:</span
                    >
                    <span>{{user.apellido}}</span>
                  </li>
                  <li class="mt-3">
                    <span class="fw-bolder  me-25"
                      >Numero de documento:</span
                    >
                    <span>{{user.dni}}</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
          <ul class="nav nav-pills mb-2">
            <li class="nav-item">
              <a class="nav-link">
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
                <span class="fw-bold">Cuenta</span></a
              >
            </li>
          </ul>

          <div class="row">
            <div class="col-12">
              <div class="card border-primary">
                <h4 class="card-header">Editar Perfil</h4>
                <div class="card-body">
                  <div>
                    <div class="row">
                      <div class="mb-1 col-md-6">
                        <label class="form-label" for="name">Nombre:</label>
                        <div class="input-group input-group-merge">
                          <input
                            class="form-control"
                            type="text"
                            v-model="user.nombre"
                            placehconf_paser="············"
                          />
                        </div>
                      </div>

                      <div class="mb-1 col-md-6">
                        <label class="form-label" for="lastname"
                          >Apellido:</label
                        >
                        <div class="input-group input-group-merge">
                          <input
                            class="form-control"
                            type="text"
                             v-model="user.apellido"
                            placehconf_paser="············"
                          />
                        </div>
                      </div>

                      <div class="mb-1 col-md-6">
                        <label class="form-label" for="email">Dni:</label>
                        <div class="input-group input-group-merge">
                          <input
                            class="form-control"
                            type="email"
                            v-model="user.dni"
                          />
                        </div>
                      </div>
                       <div class="mb-1 col-md-6">
                        <!-- <label class="form-label" for="email">Dni:</label>
                        <div class="input-group input-group-merge">
                          <input
                            class="form-control"
                            type="email"
                            id="email"
                            name="cemail"
                            placehconf_paser="············"
                          />
                        </div> -->
                      </div>

                      <div class="mb-1 col-md-6">
                        <label class="form-label" for="phone"
                          >Contraseña:</label
                        >
                        <div class="input-group input-group-merge">
                          <input
                            class="form-control"
                            type="password"
                            v-model="user.password"
                            placehconf_paser="············"
                          />
                        </div>
                      </div>

                      <div class="mb-1 col-md-6">
                        <label class="form-label" for="date_birth"
                          >Confirmar contraseña:</label
                        >
                        <div class="input-group input-group-merge">
                          <input
                            type="password"
                            class="form-control"
                          />
                        </div>
                      </div>


                      <div class="mt-3 col-md-12">
                        <div class="d-flex justify-content-end">
                          <button
                            class="
                              btn btn-primary
                              ml-1
                              waves-effect waves-float waves-light
                            "
                          >
                            Guardar Cambios
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
      user: {
        nombre:"",
        apellido:"",
        dni:"",
        password:""
      },
    };
  },
  mounted() {
    this.getData()
  },
  methods: {
    async getData(){
           axios
        .get("/perfil/info")
        .then((response) => {
          this.user = response.data;
        })
        .catch((error) => {
          console.log(error);
        }); axios.p
    }
  },
};
</script>

<style>
</style>
