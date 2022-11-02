<template>
  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div :class="['card border-left-'+color+' shadow h-100']">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div :class="['text-xs font-weight-bold text-'+color+' text-uppercase']">
              {{ kpi }}
            </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800 pt-2">
              {{ title }}
              <p class="pt-2">
                <small>{{ detail }}</small>
              </p>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    kpi: {
      type: String,
      required: true,
    },
    title: {
      type: String,
      required: true,
    },
    detail: {
      type: String,
      required: true,
      default: "0%",
    },

    color: {
        type: String,
        required: true,
        default: "primary",
    }
  },
};
</script>
