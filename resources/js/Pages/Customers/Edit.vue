<template>
  <div>
    <Head :title="`${form.name}`" />
    <h1 class="mb-12 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/customers">Customers</Link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="customer.deleted_at" class="mb-6" @restore="restore"> This customer has been deleted. </trashed-message>
    <form @submit.prevent="update">


      <div class="mx-auto ">

        <div class=" max-w-lg sm:mx-auto md:max-w-none">
          <div class="grid grid-cols-1  md:grid-cols-2 md:gap-x-12 md:gap-y-16">
            <div class="relative flex flex-col  sm:flex-row md:flex-col lg:flex-row">

              <div class="w-full bg-white rounded-md shadow overflow-hidden left-0">

                <h2 class="p-4 pb-0 pl-8 text-3xl font-bold">Personal</h2>

                <div class="flex flex-wrap -mb-8 -mr-6 p-8 ">

                  <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="First name" />

                  <text-input v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/2" label="Email" />

                </div>

                <div class="flex items-center px-8 py-6 bg-gray-50 border-t border-gray-100">
                  <inline-flash :flash="flash" />
                  <button v-if="!customer.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Contact</button>
                  <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update</loading-button>
                </div>

              </div>

            </div>

            <div class="relative flex flex-col gap-6 sm:flex-row md:flex-col lg:flex-row">


              <div class="w-full bg-white rounded-md shadow overflow-hidden right-0">


                <div class="flex  justify-between">

                  <div class="flex space-x-4">
                    <h2 class="p-4 pl-8 pb-0 text-3xl font-bold left">Membership</h2>
                  </div>

                  <div class="flex items-center space-x-4">
                    <div class="text-gray-500 pr-8 py-4 hover:text-gray-300 cursor-pointer">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="green" viewBox="0 0 40 40" stroke="green">
                        <path d="M1.36,17.427c0,0,7.311-0.122,10.844,8.163c0,0,15.474-22.175,31.435-18.885c0,0-17.789,7.067-32.045,31.922L1.36,17.427z"
                        />
                      </svg>
                    </div>
                  </div>
                </div>


                <div class="p-8">

                    <table class="table-auto w-full">

                      <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                      <tr>

                        <th class="p-2">
                          <div class="font-semibold text-left">Start Date</div>
                        </th>

                        <th class="p-2">
                          <div class="font-semibold text-left">End Date</div>
                        </th>

                        <th class="p-2">
                          <div class="font-semibold text-left">Membership</div>
                        </th>

                        <th class="p-2">
                          <div class="font-semibold text-left">Status</div>
                        </th>

                      </tr>
                      </thead>

                      <tbody class="text-sm divide-y divide-gray-100">

                      <tr v-for="(membership, index) in customerMemberships">

                        <td class="p-2">
                          <div class=" text-gray-800">
                            {{ membership.pivot.start_at }}
                          </div>
                        </td>

                        <td class="p-2">
                          <div class=" text-gray-800">
                            {{ membership.pivot.expire_at }}
                          </div>
                        </td>

                        <td class="p-2">
                          <div class="text-left text-green-500">
                            {{ membership.name }}
                          </div>
                        </td>

                        <td class="p-2">
                          <div class=" text-gray-800">
                            {{ membership.pivot.status }}
                          </div>
                        </td>

                      </tr>

                      </tbody>
                    </table>

                  <select-input v-model="form.membership" :error="form.errors.membership" class="py-8 w-full" label="Memberships">
                    <option :value="null" />
                    <option v-for="membership in memberships" :key="membership.id" :value="membership.id">{{ membership.name }}</option>
                  </select-input>

                </div>

                <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                  <inline-flash :flash="flash" />
                  <button v-if="!customer.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Cancel Membership</button>
                  <loading-button @click="addMembership" :loading="form.processing" class="btn-indigo ml-auto" type="button">Add Membership</loading-button>
                </div>

              </div>
            </div>

          </div>
        </div>
      </div>


      <div class="flex w-full">




      </div>

      <!--
      ---------------
       ADDRESS
      ---------------
      -->

      <h1 class="mb-8 text-3xl font-bold my-10">
        Phone Numbers
      </h1>


      <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">

        <div v-for="(phone, index) in customerPhones" class="flex items-center justify-center pb-6 my-3 md:py-0 md:w-1/2">

          <div  class="flex flex-col p-1.5 overflow-hidden border rounded-lg dark:border-gray-600 lg:flex-row dark:focus-within:border-blue-300 focus-within:ring focus-within:ring-opacity-40 focus-within:border-blue-400 focus-within:ring-blue-300">
            <input class="px-6 py-2 text-gray-700 placeholder-gray-500 bg-white outline-none dark:bg-gray-800 dark:placeholder-gray-400 focus:placeholder-transparent dark:focus:placeholder-transparent" type="text"
                   placeholder="Phone number" aria-label="Phone number"
                   v-model="phone.phone_number"
            >

            <button class="px-4 py-3 text-sm font-medium tracking-wider text-gray-100 uppercase transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:bg-gray-600 focus:outline-none">Delete</button>
          </div>

        </div>

        <div class="flex items-center ml-7 pb-6 my-3 md:py-0 md:w-1/2">

          <div  class="flex flex-col p-1.5 overflow-hidden border rounded-lg dark:border-gray-600 lg:flex-row dark:focus-within:border-blue-300 focus-within:ring focus-within:ring-opacity-40 focus-within:border-blue-400 focus-within:ring-blue-300">
            <input class="px-6 py-2 text-gray-700 placeholder-gray-500 bg-white outline-none dark:bg-gray-800 dark:placeholder-gray-400 focus:placeholder-transparent dark:focus:placeholder-transparent" type="text"
                   placeholder="Phone number" aria-label="Phone number"
                   v-model="form.newNumber"
            >

            <!--            <button class="px-4 py-3 text-sm font-medium tracking-wider text-gray-100 uppercase transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:bg-gray-600 focus:outline-none">Delete</button>-->
          </div>

        </div>

        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <inline-flash :flash="flash" />
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Number</loading-button>
        </div>



      </div>


      <!--
      ---------------
       ADDRESS
      ---------------
      -->

      <div class="flex max-w-3xl items-center px-8 py-4 bg-gray-50 border-t border-gray-100">

        <h1 class="mb-8 text-3xl font-bold my-10">
          Address
        </h1>

        <a @click="cloneAddress" class="btn-indigo ml-auto" type="submit">Add Address</a>

      </div>

      <div class="max-w-3xl py-10 bg-white rounded-md shadow overflow-hidden" v-for="(address, index) in customerAddress">


        <div class=" items-center ml-7 mr-7 pb-6 my-3 md:py-0">

          <div  class="flex flex-col p-1.5 overflow-hidden border rounded-lg dark:border-gray-600 lg:flex-row dark:focus-within:border-blue-300 focus-within:ring focus-within:ring-opacity-40 focus-within:border-blue-400 focus-within:ring-blue-300">
            <GMapAutocomplete
              class="px-6 py-2 text-gray-700 placeholder-gray-500 bg-white outline-none dark:bg-gray-800 dark:placeholder-gray-400 focus:placeholder-transparent dark:focus:placeholder-transparent"
              placeholder="Search Address"
              :options="{ componentRestrictions: {'country': ['PK'] }  }"
              @place_changed="setPlace($event, address)"
            >
            </GMapAutocomplete>

          </div>

          <GMapMap
            ref="myMapRef"
            :disableDefaultUI="true"
            class="h-64 mt-6"
            :center="mapCenter" :zoom="16">

            <GMapMarker
              :key="index"
              v-for="(m, index) in markers"
              :position="m.position"
              :draggable="true"
              @dragend="updateAddress"
              :icon= '{
                  url: "https://mts.googleapis.com/vt/icon/name=icons/spotlight/spotlight-waypoint-a.png&text=A&psize=16&font=fonts/Roboto-Regular.ttf&color=ff333333&ax=44&ay=48&scale=1",
                  scaledSize: {width: 30, height: 36},
                  labelOrigin: {x: 16, y: -10}
              }'
            />
          </GMapMap>

        </div>


        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">

          <div class="flex flex-wrap -mb-8 -mr-6 p-8">

            <text-input v-model="address.street_number" :error="form.errors.street_number" class="pb-8 pr-6 w-full lg:w-1/2" label="House Number" />

            <text-input v-model="address.street_name" :error="form.errors.street_number" class="pb-8 pr-6 w-full lg:w-1/2" label="Street Address" />

            <text-input v-model="address.area" :error="form.errors.area" class="pb-8 pr-6 w-full lg:w-1/2" label="Area" />

            <text-input v-model="address.city" :error="form.errors.city" class="pb-8 pr-6 w-full lg:w-1/2" label="City" />

            <text-input v-model="address.state" :error="form.errors.state" class="pb-8 pr-6 w-full lg:w-1/2" label="State" />

            <text-input v-model="address.country" :error="form.errors.country" class="pb-8 pr-6 w-full lg:w-1/2" label="Country" />

            <text-input v-model="address.postal_code" :error="form.errors.postal_code" class="pb-8 pr-6 w-full lg:w-1/2" label="Postcode" />

            <text-input v-model="address.notes" :error="form.errors.notes" class="pb-8 pr-6 w-full lg:w-1/2" label="Notes" />

          </div>

          <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
            <inline-flash :flash="flash" />
            <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update</loading-button>
          </div>

        </div>

        <!--        <div class="flex items-center ml-7 pb-6 my-3 md:py-0 md:w-1/2">-->

        <!--          <div  class="flex flex-col p-1.5 overflow-hidden border rounded-lg dark:border-gray-600 lg:flex-row dark:focus-within:border-blue-300 focus-within:ring focus-within:ring-opacity-40 focus-within:border-blue-400 focus-within:ring-blue-300">-->
        <!--            <input class="px-6 py-2 text-gray-700 placeholder-gray-500 bg-white outline-none dark:bg-gray-800 dark:placeholder-gray-400 focus:placeholder-transparent dark:focus:placeholder-transparent" type="text"-->
        <!--                   placeholder="Phone number" aria-label="Phone number"-->
        <!--                   v-model="form.newNumber"-->
        <!--            >-->

        <!--            &lt;!&ndash;            <button class="px-4 py-3 text-sm font-medium tracking-wider text-gray-100 uppercase transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:bg-gray-600 focus:outline-none">Delete</button>&ndash;&gt;-->
        <!--          </div>-->

        <!--        </div>-->


        <!--      <div v-if="form.isDirty">There are unsaved form changes.</div>-->

      </div>


    </form>
  </div>

</template>

<script>
import {Head, Link} from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'
import InlineFlash from '@/Shared/inlineFlash'

export default {
  components: {
    InlineFlash,
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    customer: Object,
    flash: Object,
    memberships: Array,
    customerMemberships: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.customer.name,
        email: this.customer.email,
        phones: this.customerPhones,
        newNumber: this.customer.newNumber,
        address:  [],
        membership: ''
      }),

      componentForm: {
        street_number: 'short_name',
        street_name: 'short_name',
        route: 'short_name',
        locality: 'long_name',
        sublocality_level_1: 'short_name',
        administrative_area_level_1: 'short_name',
        administrative_area_level_2: 'short_name',
        administrative_area_level_3: 'long_name',
        country: 'long_name',
        postal_code: 'short_name',
      },

      addressTypeConversions: {
        street_number: 'street_number',
        street_name: 'route',
        route: 'street_name',
        sublocality_level_1: 'area',
        locality: 'city',
        administrative_area_level_2: 'city',
        administrative_area_level_3: 'city',
        administrative_area_level_1: 'state',
        country: 'country',
        postal_code: 'postal_code',
        latLng: 'latLng',
        google_address_id: 'google_address_id'
      },

      mapCenter: {lat: 24.902639, lng: 67.187869},
      zoom: 13,
      markers: [
        {
          position: {
            lat: 24.902639, lng: 67.187869
          },
        }
      ]


    }
  },
  methods: {
    async update() {

      this.form.put(`/customers/${this.customer.id}`,  {
        preserveScroll: true,
        onSuccess: () => this.form.reset('newNumber'),
      })

    },

    addMembership() {

      this.form.put(`/customers/${this.customer.id}/membership`, {
        preserveScroll: true,
        onSuccess: () => this.form.reseet('membership')
      })

    },

    destroy() {
      if (confirm('Are you sure you want to delete this customer?')) {
        this.$inertia.delete(`/customers/${this.customer.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this customer?')) {
        this.$inertia.put(`/customers/${this.customer.id}/restore`)
      }
    },

    setPlace(place, address) {

      console.log(place)
      this.mapCenter.lat = place.geometry.location.lat()
      this.mapCenter.lng = place.geometry.location.lng()

      this.zoom = 16

      this.markers = [];
      let marker = {
        position: this.mapCenter,
      }
      this.markers.push(marker)

      Object.keys(address).map(
        (key) => ( this.componentForm[key] ? address[key] = null : false)
      )

      // this.form.reset(address)

      for (var i = 0; i < place.address_components.length; i++) {

        let addressType = place.address_components[i].types[0];

        if (this.componentForm[addressType]) {
          address[this.addressTypeConversions[addressType]] = place.address_components[i][this.componentForm[addressType]];
        }

      }

      address.lat = this.mapCenter.lat
      address.lng = this.mapCenter.lng
      address.google_address_id = place.place_id

    },

    cloneAddress()
    {

      let data = {}
      Object.keys(this.addressTypeConversions).map(
        (key) => (data[this.addressTypeConversions[key]] = null)
      )

      console.log(data)
      this.form.address.push(data);

    },

    updateAddress(dragged)
    {
      // this.mapCenter = dragged.latLng
      // this.form.address.latLng.lat = dragged.latLng.lat
      // this.form.address.latLng.lng = dragged.latLng.lng
      // console.log(this.form.address.latLng)
      // // this.form.address.latLng = dragged.latLng
    }

  },

  computed: {

    customerPhones: function() {
      return this.form.phones = this.customer.phones
    },

    customerAddress: function() {
      return this.form.address = this.customer.address
    },

  },

  watch: {

    customer: function()
    {
      this.form.address = this.customer.address
    }

  }

}
</script>
