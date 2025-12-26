class PaymentSystem {
    constructor() {
        this.currentTeacherId = null;
        this.currentStartDate = null;
        this.currentEndDate = null;
        this.currentTeacherName = null;
        this.unpaidSessions = [];
        this.paymentCalculation = {};
        
        this.init();
    }
    
    init() {
        this.bindEvents();
    }
    
    bindEvents() {
        // Pay button click
        document.querySelectorAll('.btn-pay').forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.currentTeacherId = e.target.dataset.teacherid;
                this.currentStartDate = e.target.dataset.startdate;
                this.currentEndDate = e.target.dataset.enddate;
                this.currentTeacherName = e.target.dataset.teachername;
                this.openPaymentPopup();
            });
        });
        
        // Payment method change
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', (e) => {
                this.handlePaymentMethodChange(e.target.value);
            });
        });
        
        // Close popup when clicking outside
        document.addEventListener('click', (e) => {
            const popup = document.getElementById('paymentPopup');
            if (popup.style.display === 'block' && !popup.contains(e.target) && 
                !e.target.classList.contains('btn-pay')) {
                this.closePaymentPopup();
            }
        });
    }
    
    async calculatePayment() {
        
        try {
            this.showLoading(true);
            
            const formData = new FormData();
            formData.append('teacherid', this.currentTeacherId);
            formData.append('startdate', this.currentStartDate);
            formData.append('enddate', this.currentEndDate);
            
            const response = await fetch(M.cfg.wwwroot + '/local/teachertimecard/calculate_payment.php', {
                method: 'POST',
                body: formData
            });
           // 
            const data = await response.json();
            //alert(data.success);
            if (data.success) {
                this.unpaidSessions = data.sessions;
                this.paymentCalculation = data.calculation;
                
                // Update UI
                document.getElementById('payment-teacher-name').textContent = this.currentTeacherName;
                document.getElementById('payment-period').textContent = 
                     'Time Period : ' + 
                    this.formatDate(this.currentStartDate) + ' - ' + 
                    this.formatDate(this.currentEndDate); //M.util.get_string('timeperiod', 'local_teachertimecard') +
                
                document.getElementById('payment-total-hours').textContent = 
                    data.calculation.total_hours.toFixed(1);
                document.getElementById('payment-total-amount').textContent = 
                    data.calculation.total_amount.toFixed(2) + ' USD';
                document.getElementById('payment-sessions-count').textContent = 
                    data.calculation.session_count;
                
            } else {
                this.showError('Error calculating payment: ' + data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            //this.showError('Error calculating payment');
        } finally {
            this.showLoading(false);
        }
    }
    
    async confirmPayment() {
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        let paymentDetails = {};
        
        // Validate payment details
        switch(paymentMethod) {
            case 'paypal':
                const paypalEmail = document.getElementById('paypalEmail').value.trim();
                if (!paypalEmail) {
                    this.showError(M.util.get_string('paypalemailrequired', 'local_teachertimecard'));
                    return;
                }
                if (!this.isValidEmail(paypalEmail)) {
                    this.showError(M.util.get_string('invalidemail', 'local_teachertimecard'));
                    return;
                }
                paymentDetails.email = paypalEmail;
                break;
                
            case 'payoneer':
                const payoneerEmail = document.getElementById('payoneerEmail').value.trim();
                if (!payoneerEmail) {
                    this.showError(M.util.get_string('payoneeremailrequired', 'local_teachertimecard'));
                    return;
                }
                if (!this.isValidEmail(payoneerEmail)) {
                    this.showError(M.util.get_string('invalidemail', 'local_teachertimecard'));
                    return;
                }
                paymentDetails.email = payoneerEmail;
                break;
                
            case 'bank_transfer':
                const bankAccount = document.getElementById('bankAccount').value.trim();
                const bankName = document.getElementById('bankName').value.trim();
                if (!bankAccount || !bankName) {
                    this.showError(M.util.get_string('bankdetailsrequired', 'local_teachertimecard'));
                    return;
                }
                paymentDetails.account = bankAccount;
                paymentDetails.bank = bankName;
                break;
        }
        
        try {
            this.showLoading(true);
            
            const response = await fetch(M.cfg.wwwroot + '/local/teachertimecard/process_payment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    teacherid: this.currentTeacherId,
                    amount: this.paymentCalculation.total_amount,
                    currency: 'USD',
                    payment_method: paymentMethod,
                    payment_details: paymentDetails,
                    period_start: Math.floor(new Date(this.currentStartDate).getTime() / 1000),
                    period_end: Math.floor(new Date(this.currentEndDate + ' 23:59:59').getTime() / 1000),
                    sessions: this.unpaidSessions
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.showSuccess(M.util.get_string('paymentsuccess', 'local_teachertimecard'));
                this.closePaymentPopup();
                
                // Refresh page after delay
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
                
            } else {
                this.showError(M.util.get_string('paymentfailed', 'local_teachertimecard') + ': ' + data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            //this.showError(M.util.get_string('paymenterror', 'local_teachertimecard'));
        } finally {
            this.showLoading(false);
        }
    }
    
    handlePaymentMethodChange(method) {
        // Hide all payment details
        document.querySelectorAll('.payment-details').forEach(el => {
            el.style.display = 'none';
        });
        
        // Show selected payment details
        document.getElementById(method + 'Details').style.display = 'block';
    }
    
    openPaymentPopup() {
        // Reset form
        document.getElementById('paypalEmail').value = '';
        document.getElementById('payoneerEmail').value = '';
        document.getElementById('bankAccount').value = '';
        document.getElementById('bankName').value = '';
        
        // Show popup
        document.getElementById('paymentPopup').style.display = 'block';
        document.querySelector('.overlay').style.display = 'block';
        
        // Calculate payment
        this.calculatePayment();
    }
    
    closePaymentPopup() {
        document.getElementById('paymentPopup').style.display = 'none';
        document.querySelector('.overlay').style.display = 'none';
    }
    
    showLoading(show) {
        document.getElementById('paymentLoading').style.display = show ? 'block' : 'none';
        document.querySelector('.payment-actions').style.display = show ? 'none' : 'flex';
    }
    
    showError(message) {
        alert(message); // You can replace with a better notification system
    }
    
    showSuccess(message) {
        alert(message); // You can replace with a better notification system
    }
    
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', { 
            day: 'numeric', 
            month: 'short', 
            year: 'numeric' 
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.paymentSystem = new PaymentSystem();
});