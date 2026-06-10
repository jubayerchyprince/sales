export type TenantStatus = 'active' | 'inactive' | 'suspended';

export type RoleName =
  | 'super_admin'
  | 'tenant_owner'
  | 'tenant_admin'
  | 'sales_agent'
  | 'support_agent'
  | 'analyst';

export interface ApiEnvelope<T> {
  data: T;
  message?: string;
}
