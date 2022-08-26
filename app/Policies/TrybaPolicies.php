<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Csp\Policies\Policy;
use Spatie\Csp\Directive;
use Spatie\Csp\Value;

class TrybaPolicies extends Policy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function configure() {
        $this->setDefaultPolicies();
    }

    protected function setDefaultPolicies()   {
        return $this->addDirective(Directive::BASE, 'self')
            ->addDirective(Directive::CONNECT, 'self')
            ->addDirective(Directive::DEFAULT, 'self')
            ->addDirective(Directive::FORM_ACTION, 'self')
            ->addDirective(Directive::IMG, 'self')
            ->addDirective(Directive::MEDIA, 'self')
            ->addDirective(Directive::OBJECT, 'self')
            ->addDirective(Directive::SCRIPT, 'self')
            ->addDirective(Directive::STYLE, 'self')
            ->addDirective(Directive::SCRIPT, '*.trustpilot.com')
            ->addDirective(Directive::SCRIPT, '*.jsdelivr.net')
            ->addDirective(Directive::SCRIPT, '*.unpkg.com')
            ->addDirective(Directive::SCRIPT, '*.sumsub.com');
    }

    private function addGoogleFontPolicies()
    {
        $this->addDirective(Directive::FONT, [
            'fonts.gstatic.com',
            'fonts.googleapis.com',
            'data:',
        ])->addDirective(Directive::STYLE, 'fonts.googleapis.com');
    }

    private function addGoogleAnalyticsPolicies()
    {
        $this->addDirective(Directive::SCRIPT, '*.googletagmanager.com')->addNonceForDirective(Directive::SCRIPT);
    }

    private function addGravatarPolicies()
    {
        $this->addDirective(Directive::IMG, '*.gravatar.com');
    }

    private function addFacebookChatbotPolicies()
    {
        $this->addDirective(Directive::SCRIPT, '*.facebook.net')
            ->addDirective(Directive::IMG, '*.facebook.com')
            ->addDirective(Directive::FRAME, '*.facebook.com')
            ->addDirective(Directive::STYLE, 'unsafe-inline');
    }

    private function addMailChimpPolicies()
    {
        $this->addDirective(Directive::FORM_ACTION, 'christoph-rumpel.us5.list-manage.com');
    }
}
