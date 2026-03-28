<x-mail::message>
# Votre commande a été finalisée

Votre commande n°{{ $order->id }} a été expédiée.

Merci pour votre achat !

<a href="{{ url('/dashboard') }}" style="background-color: #ed8936; color: #ffffff; font-weight: bold; text-decoration: none; padding: 12px 24px; border-radius: 4px; display: inline-block;">Voir votre commande</a>

Merci,<br>
{{ config('app.name') }}
</x-mail::message>
