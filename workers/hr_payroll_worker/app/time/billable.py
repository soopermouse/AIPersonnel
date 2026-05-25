from app.domain.models import BillableTimeRequest

class BillableTimeCalculator:
    def calculate(self, request: BillableTimeRequest) -> dict:
        net = round(request.billable_hours * request.billing_rate, 2)
        tax = round(net * request.tax_rate / 100, 2)
        return {
            "customer_name": request.customer_name,
            "customer_contract": request.customer_contract,
            "project_name": request.project_name,
            "project_code": request.project_code,
            "billable_net": net,
            "tax_amount": tax,
            "billable_gross": round(net + tax, 2),
            "billable_hours": request.billable_hours,
            "company_hours": request.company_hours,
            "total_hours": round(request.billable_hours + request.company_hours, 2),
        }