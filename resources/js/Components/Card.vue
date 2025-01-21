<template>
    <div
      :class="['card', { selected: isSelected(item.id) }]"
      @click="toggleSelection(item.id, $event)"
    >
      <h2
        :class="{ highlighted: isElementSelected(item.id, 'title') }"
        @click.stop="toggleElementSelection(item.id, 'title')"
      >
        {{ item.jmeno }} {{ item.prijmeni }}
      </h2>
      <p
        :class="{ highlighted: isElementSelected(item.id, 'birth_date') }"
        @click.stop="toggleElementSelection(item.id, 'birth_date')"
      >
        Birth Date: {{ item.datum }}
      </p>
      <p
        :class="{ highlighted: isElementSelected(item.id, 'country') }"
        @click.stop="toggleElementSelection(item.id, 'country')"
      >
        Country: {{ item.country.name }}
      </p>

      <h3 class="card-subtitle">Hobbies:</h3>
      <ul class="card-list">
        <li
          v-for="(hobby, index) in item.hobbies"
          :key="hobby.id"
          :class="{ highlighted: isElementSelected(item.id, `hobby-${hobby.id}`) }"
          @click.stop="toggleElementSelection(item.id, `hobby-${hobby.id}`)"
        >
          {{ hobby.name }}
        </li>
      </ul>
    </div>
  </template>

  <script setup>
 import { reactive } from 'vue';

  const props = defineProps({
    item: {
      type: Object,
      required: true,
    }

  });


  const selectedItems = reactive({});
  const selectedElements = reactive({});
  const toggleSelection = (id, event) => {
    if (event.target === event.currentTarget) {
      if (selectedItems[id]) {
        delete selectedItems[id];
      } else {
        selectedItems[id] = true;
      }
    }
  };

  const toggleElementSelection = (id, element) => {
    if (!selectedElements[id]) {
      selectedElements[id] = {};
    }
    selectedElements[id][element] = !selectedElements[id][element];
  };

  const isSelected = (id) => selectedItems[id];
  const isElementSelected = (id, element) => selectedElements[id]?.[element] || false;
  </script>

  <style scoped>
  .card {
    flex: 1 1 calc(33.33% - 16px);
    box-sizing: border-box;
    padding: 16px;
    border: 1px solid #d1d5db;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    background-color: #ffffff;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  .card:hover {
    background-color: #f9fafb;
  }

  .card.selected {
    background-color: #ebf8ff;
    border-color: #93c5fd;
  }

  .highlighted {
    background-color: #1863d4b5;
    transition: background-color 0.3s;
  }

  .card-title {
    font-size: 1.25rem;
    font-weight: bold;
    margin-bottom: 8px;
  }

  .card-text {
    margin: 4px 0;
  }

  .card-subtitle {
    margin-top: 16px;
    font-weight: bold;
  }

  .card-list {
    list-style-type: disc;
    padding-left: 16px;
    margin-top: 8px;
  }
  </style>
