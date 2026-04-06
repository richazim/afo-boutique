<x-mail::message>
    <div style="background-color: #f7fafc; ">
        <div style="background-color: #ffffff; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 4px; overflow: hidden;">
            <div style="padding: 20px;">
                <h1 style="font-size: 24px; font-weight: bold; color: #ed8936; margin-bottom: 16px;">Merci pour votre achat !</h1>
                <h3>Commande : #{{$order->id}}</h3>
                <p style="color: #4a5568; margin-bottom: 16px;">
                    Nous avons bien reçu votre commande et elle est en cours de traitement. Vous recevrez prochainement un e-mail de confirmation contenant les détails de votre commande.
                </p>
                <p style="color: #4a5568; margin-bottom: 16px;">
                    Si vous avez des questions ou besoin d'assistance, n'hésitez pas à contacter notre service client.
                </p>
                <a href="{{ url('/dashboard') }}" style="background-color: #ed8936; color: #ffffff; font-weight: bold; text-decoration: none; padding: 12px 24px; border-radius: 4px; display: inline-block;">Voir votre commande</a>
            </div>
            <div style="background-color: #f7fafc; padding: 10px; border-raduis: 10px; display: flex; justify-content: space-between; align-items: center;">
                <p style="color: #4a5568;">
                    Merci, {{$order->user->name}}<br>
                    {{ config('app.name') }}
                </p>
            </div>
            <a href="#" style="color: #ed8936; text-decoration: none;">Contacter le support Afo Shopi</a>
        </div>
    </div>
</x-mail::message>
