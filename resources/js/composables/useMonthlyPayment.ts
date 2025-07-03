import { computed, Ref, isRef } from 'vue';

export const useMonthlyPayment = (total: number | Ref<number>, interestRate: number | Ref<number>, duration: number | Ref<number>) => {

    const realTotal = computed(() => isRef(total) ? total.value : total);
    const realInterestRate = computed(() => isRef(interestRate) ? interestRate.value : interestRate);
    const realDuration = computed(() => isRef(duration) ? duration.value : duration);

    const monthlyPayment = computed(() => {
        const principle = realTotal.value;
        const monthlyInterest = realInterestRate.value / 100 / 12;
        const numberOfPaymentMonths = realDuration.value * 12;

        return (
            (principle * monthlyInterest * Math.pow(1 + monthlyInterest, numberOfPaymentMonths)) /
            (Math.pow(1 + monthlyInterest, numberOfPaymentMonths) - 1)
        );
    });

    const totalPaid = computed(() => {
        return realDuration.value * 12 * monthlyPayment.value;
    });

    const totalInterest = computed(() => {
        return totalPaid.value - realTotal.value;
    });

    return { monthlyPayment, totalPaid, totalInterest }
}
