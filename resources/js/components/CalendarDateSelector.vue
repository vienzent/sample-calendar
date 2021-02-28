<template>
    <div class="calendar-date-selector h3">
        <span @click.prevent="selectPrevious" :class="{'add-pointer': !disableSelector } ">&lt;</span>
        <span>{{ selectedMonth }}</span>
        <span @click.prevent="selectNext" :class="{'add-pointer': !disableSelector } ">&gt;</span>
    </div>
</template>

<script>
import dayjs from "dayjs";

export default {
    name: "CalendarDateSelector",
    props: {
        selectedDate: {
            type: Object,
            required: true
        },
        disableSelector: {
            type: Boolean,
            required: false,
            default: false
        },
    },
    methods: {
        selectPrevious() {
            if (this.disableSelector) return;
            let newSelectedDate = dayjs(this.selectedDate).subtract(1, "month");
            this.$emit("dateselected", newSelectedDate);
        },

        selectNext() {
            if (this.disableSelector) return;
            let newSelectedDate = dayjs(this.selectedDate).add(1, "month");
            this.$emit("dateselected", newSelectedDate);
        }
    },
    computed: {
        selectedMonth() {
            return this.selectedDate.format("MMMM YYYY");
        }
    }
}
</script>

<style scoped>
.add-pointer {
    cursor: pointer;
    user-select: none;
}
</style>
