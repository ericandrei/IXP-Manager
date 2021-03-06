<?php
/*
 * Copyright (C) 2009-2017 Internet Neutral Exchange Association Company Limited By Guarantee.
 * All Rights Reserved.
 *
 * This file is part of IXP Manager.
 *
 * IXP Manager is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation, version v2.0 of the License.
 *
 * IXP Manager is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License v2.0
 * along with IXP Manager.  If not, see:
 *
 * http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace IXP\Http\Controllers;

use App, D2EM;

use Entities\{
    Customer         as CustomerEntity,
    Infrastructure   as InfrastructureEntity,
    IXP              as IXPEntity,
    Switcher         as SwitchEntity,
    VirtualInterface as VIEntity,
    Vlan             as VlanEntity,
    VlanInterface    as VlanInterfaceEntity
};


use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

use IXP\Http\Requests\StatisticsRequest;
use IXP\Services\Grapher\Graph;
use IXP\Utils\View\Alert\Alert;
use IXP\Utils\View\Alert\Container as AlertContainer;


/**
 * Statistics Controller
 * @author     Barry O'Donovan <barry@islandbridgenetworks.ie>
 * @category   Statistics
 * @copyright  Copyright (C) 2009-2017 Internet Neutral Exchange Association Company Limited By Guarantee
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL V2.0
 */
class StatisticsController extends Controller
{

    /**
     * Process and update request parameters for standard graph attributes: period, category, protocol, type.
     *
     * These are safe for use from the request.
     *
     * @param StatisticsRequest $r
     */
    private function processGraphParams( StatisticsRequest $r ) {
        $r->period   = Graph::processParameterPeriod(   $r->input( 'period',   '' ) );
        $r->category = Graph::processParameterCategory( $r->input( 'category', '' ) );
        $r->protocol = Graph::processParameterProtocol( $r->input( 'protocol', '' ) );
        $r->type     = Graph::processParameterType(     $r->input( 'type',     '' ) );
    }


    /**
     * Show overall IXP graphs
     *
     * @param StatisticsRequest $r
     * @param string $category Category of graph to show (e.g. bits / pkts)
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function ixp( StatisticsRequest $r, string $category = Graph::CATEGORY_BITS )
    {
        $ixp      = D2EM::getRepository( IXPEntity::class )->getDefault();
        $grapher  = App::make('IXP\Services\Grapher');
        $category = Graph::processParameterCategory( $category, true );

        $graph = $grapher->ixp( $ixp )->setType( Graph::TYPE_PNG )->setProtocol( Graph::PROTOCOL_ALL )->setCategory( $category );
        $graph->authorise();

        return view( 'statistics/ixp' )->with([
            'graph'    => $graph,
            'category' => $category,
        ]);
    }

    /**
     * Show IXP infrastructure graphs
     *
     * @param StatisticsRequest $r
     * @param int $infraid ID of the infrastructure to show the graph of
     * @param string $category Category of graph to show (e.g. bits / pkts)
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function infrastructure( StatisticsRequest $r, int $infraid = 0, string $category = Graph::CATEGORY_BITS )
    {
        /** @var InfrastructureEntity[] $eInfras */
        $eInfras  = D2EM::getRepository( InfrastructureEntity::class )->findBy( [], [ 'name' => 'ASC' ] );
        $grapher  = App::make('IXP\Services\Grapher');
        $category = Graph::processParameterCategory( $category, true );

        $infras = [];
        foreach( $eInfras as $i ) {
            $infras[ $i->getId() ] = $i->getName();
        }

        $infraid  = isset( $infras[ $infraid ] ) ? $infraid : array_keys( $infras )[0];
        $infra    = D2EM::getRepository( InfrastructureEntity::class )->find( $infraid );
        $graph    = $grapher->infrastructure( $infra )->setType( Graph::TYPE_PNG )->setProtocol( Graph::PROTOCOL_ALL )->setCategory( $category );

        $graph->authorise();

        return view( 'statistics/infrastructure' )->with([
            'infras'   => $infras,
            'infraid'  => $infraid,
            'infra'    => $infra,
            'graph'    => $graph,
            'category' => $category,
        ]);
    }

    /**
     * Show IXP switch graphs
     *
     * @param StatisticsRequest $r
     * @param int $switchid ID of the switch to show the graph of
     * @param string $category Category of graph to show (e.g. bits / pkts)
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function switch( StatisticsRequest $r, int $switchid = 0, string $category = Graph::CATEGORY_BITS )
    {
        /** @var SwitchEntity[] $eSwitches */
        $eSwitches = D2EM::getRepository( SwitchEntity::class )->getAndCache( true, SwitchEntity::TYPE_SWITCH );
        $grapher = App::make('IXP\Services\Grapher');
        $category = Graph::processParameterCategory( $category, true );

        $switches = [];
        foreach( $eSwitches as $s ) {
            $switches[ $s->getId() ] = $s->getName();
        }

        $switchid = isset( $switches[ $switchid ] ) ? $switchid : array_keys( $switches )[0];
        $switch   = D2EM::getRepository( SwitchEntity::class )->find( $switchid );
        $graph    = $grapher->switch( $switch )->setType( Graph::TYPE_PNG )->setProtocol( Graph::PROTOCOL_ALL )->setCategory( $category );

        $graph->authorise();

        return view( 'statistics/switch' )->with([
            'switches'  => $switches,
            'switchid'  => $switchid,
            'switch'    => $switch,
            'graph'     => $graph,
            'category'  => $category,
        ]);
    }


    /**
     * Show IXP trunk graphs
     *
     * @param StatisticsRequest $r
     * @param string $trunkid ID of the trunk to show the graph of
     * @param string $category Category of graph to show (e.g. bits / pkts)
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function trunk( StatisticsRequest $r, string $trunkid = null, string $category = Graph::CATEGORY_BITS )
    {
        if( !is_array( config('grapher.backends.mrtg.trunks') ) || !count( config('grapher.backends.mrtg.trunks') ) ) {
            AlertContainer::push(
                "Trunk graphs have not been configured. Please see <a href=\"http://docs.ixpmanager.org/features/grapher/\">this documentation</a> for instructions.",
                Alert::DANGER
            );
            return redirect('');
        }

        $grapher = App::make('IXP\Services\Grapher');

        // get the available graphs
        $images = [];
        $graphs = [];
        foreach( config('grapher.backends.mrtg.trunks') as $g ) {
            $images[]           = $g['name'];
            $graphs[$g['name']] = $g['title'];
        }

        if( !in_array( $trunkid, $images ) ) {
            $trunkid = $images[ 0 ];
        }

        $graph = $grapher->trunk( $trunkid )->setType( Graph::TYPE_PNG )->setProtocol( Graph::PROTOCOL_ALL )->setCategory( Graph::CATEGORY_BITS );
        $graph->authorise();

        return view( 'statistics/trunk' )->with([
            'graphs'    => $graphs,
            'trunkid'   => $trunkid,
            'graph'     => $graph,
            'category'  => $category,
        ]);
    }



    /**
     * Display all member graphs
     *
     * @param StatisticsRequest $r
     * @return  View
     */
    public function members( StatisticsRequest $r ) : View {

        $grapher = App::make('IXP\Services\Grapher');
        $this->processGraphParams($r);

        // do we have an infrastructure or vlan?
        $vlan = $infra = false;
        if( $r->input( 'infra' ) && ( $infra = D2EM::getRepository(InfrastructureEntity::class) ->find($r->input('infra')) ) ) {
            $targets = D2EM::getRepository(VIEntity::class)->getObjectsForInfrastructure($infra);
            $r->protocol = Graph::PROTOCOL_ALL;
        } else if( $r->input( 'vlan' ) && ( $vlan = D2EM::getRepository(VlanEntity::class)->find($r->input('vlan')) ) ) {
            if( !in_array( $r->protocol, Graph::PROTOCOLS_REAL ) ) {
                $r->protocol = Graph::PROTOCOL_IPV4;
            }
            $targets = D2EM::getRepository( VlanInterfaceEntity::class )->getObjectsForVlan( $vlan, false, $r->protocol );
        } else {
            $targets = D2EM::getRepository( CustomerEntity::class )->getCurrentActive( false, true, false );
            $r->protocol = Graph::PROTOCOL_ALL;
        }

        $graphs = [];
        foreach( $targets as $t ) {
            if( $infra ) {
                $g = $grapher->virtint( $t );
            } else if( $vlan ) {
                $g = $grapher->vlanint( $t );
            } else {
                $g = $grapher->customer( $t );
            }

            $g->setType(     Graph::TYPE_PNG )
                ->setProtocol( $r->protocol   )
                ->setCategory( $r->category   )
                ->setPeriod(   $r->period     );

            $graphs[] = $g;
        }

        return view( 'statistics/members' )->with([
            'graph'        => $graphs[0] ?? false,  // sample graph as all types/protocols/categories/periods will be the same
            'graphs'       => $graphs,
            'r'            => $r,
            'infras'       => D2EM::getRepository( InfrastructureEntity::class )->getNames(),
            'infra'        => $infra ?? false,
            'vlans'       => D2EM::getRepository( VlanEntity::class )->getNames(),
            'vlan'        => $vlan ?? false,
        ]);
    }
}
