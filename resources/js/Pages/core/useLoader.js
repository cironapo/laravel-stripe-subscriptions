import { ref } from 'vue'

const isLoading = ref(false)

export function useLoader() {
  return {
    isLoading
  }
}

export function setLoader(state) {
  isLoading.value = state
}