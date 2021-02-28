<template>
    <b-form @submit.prevent="addEvent">
        <b-form-group
            label="Event"
            label-for="event_name"
        >
            <b-form-input
                id="event_name"
                v-model="event.name"
                type="text"
                placeholder="Enter name"

                :state="state('name')"
                @input="errors.clear('name')"
                :disabled="isSaving"
            ></b-form-input>

            <b-form-invalid-feedback>
                {{ errors.get('name') }}
            </b-form-invalid-feedback>
        </b-form-group>
        <b-form-row>
            <b-col>
                <b-form-group
                    label="From"
                    label-for="start_date"
                >
                    <b-form-datepicker
                        id="start_date"
                        v-model="event.start_date"
                        class="mb-2"
                        @input="onChangeStartDate"
                        :state="state('start_date')"
                        :disabled="isSaving"
                    ></b-form-datepicker>
                    <b-form-invalid-feedback>
                        {{ errors.get('start_date') }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </b-col>
            <b-col>
                <b-form-group
                    label="To"
                    label-for="end_date"
                >
                    <b-form-datepicker
                        id="end_date"
                        :min="event.start_date"
                        v-model="event.end_date"
                        class="mb-2"
                        @input="onChangeEndDate"
                        :state="state('end_date')"
                        :disabled="isSaving"
                    ></b-form-datepicker>
                    <b-form-invalid-feedback>
                        {{ errors.get('end_date') }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </b-col>
        </b-form-row>
        <b-form-group label-for="event_days">
            <b-form-checkbox-group
                id="event_days"
                v-model="event.days"
                :state="state('days')"
                @input="errors.clear('days')"
                :disabled="isSaving"
            >
                <b-form-checkbox value="1" :disabled="!hasDayOfWeek(1)">Mon</b-form-checkbox>
                <b-form-checkbox value="2" :disabled="!hasDayOfWeek(2)">Tue</b-form-checkbox>
                <b-form-checkbox value="3" :disabled="!hasDayOfWeek(3)">Wed</b-form-checkbox>
                <b-form-checkbox value="4" :disabled="!hasDayOfWeek(4)">Thu</b-form-checkbox>
                <b-form-checkbox value="5" :disabled="!hasDayOfWeek(5)">Fri</b-form-checkbox>
                <b-form-checkbox value="6" :disabled="!hasDayOfWeek(6)">Sat</b-form-checkbox>
                <b-form-checkbox value="0" :disabled="!hasDayOfWeek(0)">Sun</b-form-checkbox>
                <b-form-invalid-feedback :state="state('days')">
                    {{ errors.get('days') }}
                </b-form-invalid-feedback>
            </b-form-checkbox-group>

        </b-form-group>
        <b-button type="submit" variant="primary" :disabled="errors.any() || isSaving">
            <b-spinner v-if="isSaving" small type="grow"></b-spinner>
            {{ isSaving ? "Saving..." : "Save" }}
        </b-button>
    </b-form>
</template>

<script>

import Errors from "../Errors";

export default {
    name: "CalendarEventAddForm",
    data() {
        return {
            event: {
                name: null,
                start_date: null,
                end_date: null,
                days: [],
            },
            errors: new Errors(),
            isSaving: false,
        }
    },
    methods: {
        async addEvent() {

            if (this.isSaving) return;

            try {

                this.isSaving = true;

                let response = await axios.post("/api/calendar/events", this.event);

                this.resetForm();

                this.$emit('eventadded', response.data);

            } catch (e) {
                this.errors.record(e.response.data.errors)
            } finally {
                this.isSaving = false;
            }

        },
        onChangeStartDate() {
            if (this.startDate > this.endDate) {
                this.event.end_date = this.event.start_date;
            }
            this.filterEventDays();
            this.errors.clear('start_date');
        },
        onChangeEndDate() {
            this.filterEventDays();
            this.errors.clear('end_date');
        },
        hasDayOfWeek(day) {

            let start = new Date(this.event.start_date); // this.startDate
            let end = new Date(this.event.end_date);

            if (start === null) return;

            while (start <= end) {
                if (start.getDay() === +day) return true;
                start.setDate(start.getDate() + 1);
            }

            return false;
        },
        filterEventDays() {
            this.event.days = this.event.days.filter(d => this.hasDayOfWeek(d));
        },
        state(field) {
            return this.errors.has(field) ? false : null;
        },
        resetForm() {
            this.event.start_date = null;
            this.event.end_date = null;
            this.event.days = []
            this.event.name = null
            this.errors.clear();
        }
    },
    computed: {
        startDate() {
            return Date.parse(this.event.start_date);
        },
        endDate() {
            return Date.parse(this.event.end_date);
        },

    },
}
</script>

<style scoped>
.custom-checkbox {
    margin-right: 0.65rem;
}
</style>
