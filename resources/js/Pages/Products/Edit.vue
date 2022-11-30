<template>
  <div>
    <Head :title="form.name" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/products">Products</Link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="product.deleted_at" class="mb-6" @restore="restore"> This product has been deleted. </trashed-message>
    <div class="w-full mb-8 bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">

        <div class="flex flex-wrap -mb-8 -mr-6 p-8">

          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/3" label="Name" />

          <text-input v-model="form.description" :error="form.errors.description" class="pb-8 pr-6 w-full lg:w-2/3" label="Description" />

          <select-input v-model="form.types_id" :error="form.errors.types_id" class="pb-8 pr-6 w-full lg:w-1/3" label="Parent">
            <option v-for="type in types" :value="type.id">{{ type.name }}</option>
          </select-input>

          <select-input v-model="form.status" :error="form.errors.status" class="pb-8 pr-6 w-full lg:w-1/3" label="Status">
            <option value="draft">Draft</option>
            <option value="published">Published</option>
            <option value="unlisted">Unlisted</option>
          </select-input>

          <select class="select" multiple>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
            <option value="4">Four</option>
            <option value="5">Five</option>
          </select>
          <label class="form-label select-label">Example label</label>

        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
<!--          <button v-if="!product.deleted_at" class="text-red-600 hover:underline" tabindex="-1" product="button" @click="destroy">Delete Product</button>-->
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" product="submit">Update Product</loading-button>
        </div>
      </form>
    </div>

    <div class="w-full bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">

        <div class="flex flex-wrap -mb-8 -mr-6 p-8">

          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/3" label="Name" />

          <text-input v-model="form.description" :error="form.errors.description" class="pb-8 pr-6 w-full lg:w-2/3" label="Description" />

          <select-input v-model="form.types_id" :error="form.errors.types_id" class="pb-8 pr-6 w-full lg:w-1/3" label="Parent">
            <option v-for="type in types" :value="type.id">{{ type.name }}</option>
          </select-input>

          <select-input v-model="form.status" :error="form.errors.status" class="pb-8 pr-6 w-full lg:w-1/3" label="Status">
            <option value="draft">Draft</option>
            <option value="published">Published</option>
            <option value="unlisted">Unlisted</option>
          </select-input>

        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <!--          <button v-if="!product.deleted_at" class="text-red-600 hover:underline" tabindex="-1" product="button" @click="destroy">Delete Product</button>-->
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" product="submit">Update Product</loading-button>
        </div>
      </form>
    </div>

  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  components: {
    Head,
    Icon,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    product: Object,
    types: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.product.name,
        description: this.product.description,
        types_id: this.product.types_id ?? 1,
        status: this.product.status
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/products/${this.product.id}`)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this product?')) {
        this.$inertia.delete(`/products/${this.product.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this product?')) {
        this.$inertia.put(`/products/${this.product.id}/restore`)
      }
    },
  },
}
</script>
