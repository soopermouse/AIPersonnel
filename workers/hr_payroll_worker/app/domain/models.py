from pydantic import BaseModel, Field
from typing import Any

class PayrollEmployee(BaseModel):
    name: str
    country_code: str = "NL"
    employment_type: str = "employee"
    monthly_wage: float = 0.0
    hourly_rate: float = 0.0
    hours_worked: float = 0.0
    tax_code: str | None = None
    benefits: dict[str, Any] = Field(default_factory=dict)

class PayrollCalculationRequest(BaseModel):
    period: str
    country_code: str = "NL"
    employees: list[PayrollEmployee]

class PayrollCalculationResult(BaseModel):
    period: str
    country_code: str
    gross_pay: float
    employee_taxes: float
    employer_taxes: float
    benefits_cost: float
    net_pay: float
    details: list[dict[str, Any]]

class BillableTimeRequest(BaseModel):
    customer_name: str
    customer_contract: str | None = None
    project_name: str
    project_code: str
    billable_hours: float
    company_hours: float
    billing_rate: float
    tax_rate: float = 21.0