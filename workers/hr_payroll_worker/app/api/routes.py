from fastapi import APIRouter
from app.domain.models import PayrollCalculationRequest, BillableTimeRequest
from app.payroll.calculator import PayrollCalculator
from app.time.billable import BillableTimeCalculator

router = APIRouter()

@router.post("/hr/payroll/calculate")
def calculate_payroll(request: PayrollCalculationRequest):
    return PayrollCalculator().calculate(request)

@router.post("/hr/billable-time/calculate")
def calculate_billable_time(request: BillableTimeRequest):
    return BillableTimeCalculator().calculate(request)

@router.get("/hr/tax-codes/supported")
def supported_tax_codes():
    return {
        "supported": ["NL", "UK", "US"],
        "note": "Scaffold estimates only. Production needs verified payroll tax tables per jurisdiction.",
    }