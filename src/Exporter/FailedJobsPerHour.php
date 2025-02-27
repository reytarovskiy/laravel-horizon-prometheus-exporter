<?php


namespace LKDevelopment\HorizonPrometheusExporter\Exporter;


use Laravel\Horizon\Contracts\JobRepository;
use Laravel\Horizon\Contracts\MetricsRepository;
use LKDevelopment\HorizonPrometheusExporter\Contracts\Exporter;
use Prometheus\CollectorRegistry;
use Superbalist\LaravelPrometheusExporter\PrometheusExporter;

class FailedJobsPerHour implements Exporter
{
    protected $gauge;

    public function metrics(CollectorRegistry $prometheusExporter)
    {

        $this->gauge = $prometheusExporter->registerGauge(
            config('horizon-exporter.namespace'),
            'horizon_failed_jobs',
            'The number of recently failed jobs',
        );
    }

    public function collect()
    {
        $this->gauge->set(app(JobRepository::class)->countRecentlyFailed());
    }
}
