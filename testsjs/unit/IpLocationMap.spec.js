import {config, createLocalVue, shallowMount} from '@vue/test-utils'
import IpLocationMap from '../../resources/js/components/maps/IpLocationMap.vue'
import axios from "axios";

window.axios = axios
config.mocks['asset'] = (key) => key
config.mocks['trans'] = (key) => key

const localVue = createLocalVue()
localVue.mixin(require('../../resources/js/mixins/mock-trans'))

describe('IpLocationMap.vue', () => {
    it('renders map when location has latitude and longitude', () => {

        const locationData = {
            latitude: 40.7128,
            longitude: -74.0060,
            city: 'New York',
            countryCode: 'US',
            region: 'New York',
            ip: '203.0.113.123'
        }

        const token = 'your_google_maps_token'
        const wrapper = shallowMount(IpLocationMap, {
            propsData: { locationData, token }
        })

        expect(wrapper.find('.table').exists()).toBe(true)
    })

    it('does not render map when location does not have latitude and longitude', () => {
        const localVue = createLocalVue()
        localVue.mixin(require('../../resources/js/mixins/mock-trans'))
        const locationData = {
            city: 'New York',
            countryCode: 'US',
            region: 'New York'
        }
        const token = 'your_google_maps_token'
        const wrapper = shallowMount(IpLocationMap, {
            propsData: { locationData, token }
        })

        expect(wrapper.find('.card.card-default').exists()).toBe(false)
    })
})