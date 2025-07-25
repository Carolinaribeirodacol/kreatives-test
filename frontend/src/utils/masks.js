export function maskEmail(email) {
  if (!email) return '';

  const [local, domain] = email.split('@');
  if (!local || !domain) return email;

  const maskedLocal =
    local.length <= 2
      ? local[0] + '*'.repeat(local.length - 1)
      : local[0] + '*'.repeat(local.length - 2) + local.slice(-1);

  return `${maskedLocal}@${domain}`;
}