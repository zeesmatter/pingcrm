<template>
  <div>
    <Head :title="`${form.name} ${form.price}`" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/memberships">Memberships</Link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }} {{ form.price }}
    </h1>
    <trashed-message v-if="membership.deleted_at" class="mb-6" @restore="restore"> This membership has been deleted. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />
          <text-input v-model="form.price" :error="form.errors.price" class="pb-8 pr-6 w-full lg:w-1/2" label="Price" />
          <text-input v-model="form.period" :error="form.errors.period" class="pb-8 pr-6 w-full lg:w-1/2" label="Period" />
          <toggle v-model="form.trial_allowed" :error="form.errors.trial_allowed" class="pb-8 pr-6 w-full lg:w-1/2" label="Trial Allowed"/>
          <toggle v-model="form.status"  :error="form.errors.status" class="pb-8 pr-6 w-full lg:w-1/2" label="Status"/>
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!membership.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete membership</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update membership</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'
import Toggle from '@/Shared/Toggle'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
    Toggle
  },
  layout: Layout,
  props: {
    membership: Object,
    organizations: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.membership.name,
        price: this.membership.price,
        trial_allowed: this.membership.trial_allowed,
        period: this.membership.period,
        status: this.membership.status,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/memberships/${this.membership.id}`)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this membership?')) {
        this.$inertia.delete(`/memberships/${this.membership.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this membership?')) {
        this.$inertia.put(`/memberships/${this.membership.id}/restore`)
      }
    },
  },
}
</script>
