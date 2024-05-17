<template>
  <div>
      <template v-if="showMap">
        <table class="table table-borderless" aria-describedby="table-local">
            <tbody>
            <tr>
                <th class="text-uppercase label-detail">IP</th>
                <td class="detail detail-shipping">
                    {{ (this.ip ?? '') }}
                </td>
            </tr>
            <tr>
                <th class="text-uppercase label-detail">{{trans('common.place')}}</th>
                <td class="detail detail-shipping">
                    {{ location.countryCode.toUpperCase() }}
                    {{ (location.region.toUpperCase() ? ' - ' + location.region.toUpperCase() : '') }}
                    {{ (location.city.toUpperCase() ? location.city.toUpperCase() : '') }}
                </td>
            </tr>
            </tbody>
        </table>
        <div>
          <div style="min-height: 214px">
            <img :src="urlMapStatic" :class="mapClasses" alt="map"/>
          </div>
        </div>
      </template>
      <div v-if="hasError" class="mt-5">
        <div class="d-flex flex-column justify-content-center align-items-center gap-3 h-100">
          <img :src="asset('images/svg/error.svg')" alt="error"/>
          <h5 v-text="error"></h5>
        </div>
      </div>
  </div>
</template>

<script>
const ROUTE_PATH = '/api/ip/location'

export default {
name: 'IpLocationMap',
props: {
  ip: {
    type: String,
    default: ''
  },
  token: {
    type: String,
    required: true
  },
  landscape: {
    type: Boolean,
    default: false
  }
},
data () {
  return {
    location: {},
    error: null,
    showMap: false
  }
},
computed: {
  urlMapStatic () {
    return `https://maps.googleapis.com/maps/api/staticmap?${new URLSearchParams(this.mapConfig).toString()}&${this.markerConfig}`
  },
  markers () {
    return [
      { id: 'ipMarker', position: this.locationPosition }
    ]
  },
  locationPosition () {
    return { lat: this.location.latitude, lng: this.location.longitude }
  },
  markerConfig () {
    return `markers=color:red%7C${this.location.latitude},${this.location.longitude}`
  },
  mapConfig () {
    return {
      size: '800x450',
      maptype: 'roadmap',
      center: [this.location.latitude, this.location.longitude],
      zoom: 12,
      key: this.token
    }
  },
  mapClasses () {
    return {
      'img-fluid': true,
      'h-100': true,
      'w-100': true,
      'landscape-map': this.landscape
    }
  },
  hasError () {
    return !this.showMap || Boolean(this.error)
  }
},
created () {
  this.getLocationInfo()
},
methods: {
  getLocationInfo () {
    window.axios.get(ROUTE_PATH, {
      params: {
        ip: this.ip
      }
    }).then(({ data: { information } }) => {
      this.location = information

      if (this.location.latitude && this.location.longitude) {
        this.showMap = true
      }
    }).catch(error => {
      this.error = error.message
    })
  }
}
}
</script>