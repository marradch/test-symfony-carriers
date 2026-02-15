<script setup lang="ts">
import { ref } from 'vue'

interface ShippingResponse {
  carrier: string
  weightKg: number
  currency: string
  price: number
}

const weightKg = ref<number | null>(null)
const carrier = ref<string>('transcompany')
const result = ref<ShippingResponse | null>(null)
const error = ref<string | null>(null)
const loading = ref<boolean>(false)

const calculate = async (): Promise<void> => {
  if (!weightKg.value || weightKg.value <= 0) {
    error.value = 'Please enter a valid weight'
    return
  }

  result.value = null
  error.value = null
  loading.value = true

  try {
    const response = await fetch('http://localhost:8080/api/shipping/calculate', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        carrier: carrier.value,
        weightKg: weightKg.value
      })
    })

    const data = await response.json()

    if (!response.ok) {
      error.value = data.error || 'Unexpected error'
      return
    }

    result.value = data as ShippingResponse
  } catch (e) {
    error.value = 'Network error'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div id="app">
    <div class="card">
      <h1>Shipping Calculator</h1>

      <div class="form-group">
        <label>Parcel Weight (kg)</label>
        <input
            type="number"
            step="0.1"
            v-model.number="weightKg"
        />
      </div>

      <div class="form-group">
        <label>Carrier</label>
        <select v-model="carrier">
          <option value="transcompany">TransCompany</option>
          <option value="packgroup">PackGroup</option>
        </select>
      </div>

      <button @click="calculate" :disabled="loading">
        {{ loading ? 'Calculating...' : 'Calculate price' }}
      </button>

      <div v-if="result" class="result">
        <h2>{{ result.price }} {{ result.currency }}</h2>
      </div>

      <div v-if="error" class="error">
        {{ error }}
      </div>
    </div>
  </div>
</template>

<style scoped>
.form-group {
  margin-bottom: 1.2rem;
  display: flex;
  flex-direction: column;
  gap: 0.4rem;
}

input,
select {
  padding: 0.6em;
  border-radius: 8px;
  border: 1px solid #555;
  background: transparent;
  color: inherit;
  font-size: 1em;
}

input:focus,
select:focus {
  outline: none;
  border-color: #646cff;
}

.result {
  margin-top: 1.5rem;
  font-size: 1.4em;
  font-weight: 600;
}

.error {
  margin-top: 1rem;
  color: #ff4d4d;
  font-weight: 500;
}
</style>
