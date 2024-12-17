<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

/**
 * The "fhir" collection of methods.
 * Typical usage is:
 *  <code>
 *   $healthcareService = new Google_Service_CloudHealthcare(...);
 *   $fhir = $healthcareService->fhir;
 *  </code>
 */
class Google_Service_CloudHealthcare_Resource_ProjectsLocationsDatasetsFhirStoresFhir extends Google_Service_Resource
{
  /**
   * Retrieves the N most recent `Observation` resources for a subject matching
   * search criteria specified as query parameters, grouped by `Observation.code`,
   * sorted from most recent to oldest.
   *
   * Implements the FHIR extended operation [Observation-
   * lastn](http://hl7.org/implement/standards/fhir/STU3/observation-
   * operations.html#lastn).
   *
   * Search terms are provided as query parameters following the same pattern as
   * the search method. This operation accepts an additional query parameter
   * `max`, which specifies N, the maximum number of Observations to return from
   * each group, with a default of 1.
   *
   * On success, the response body will contain a JSON-encoded representation of a
   * `Bundle` resource of type `searchset`, containing the results of the
   * operation. Errors generated by the FHIR store will contain a JSON-encoded
   * `OperationOutcome` resource describing the reason for the error. If the
   * request cannot be mapped to a valid API method on a FHIR store, a generic GCP
   * error might be returned instead. (fhir.ObservationLastn)
   *
   * @param string $parent Name of the FHIR store to retrieve resources from.
   * @param array $optParams Optional parameters.
   * @return Google_Service_CloudHealthcare_HttpBody
   */
  public function ObservationLastn($parent, $optParams = array())
  {
    $params = array('parent' => $parent);
    $params = array_merge($params, $optParams);
    return $this->call('Observation-lastn', array($params), "Google_Service_CloudHealthcare_HttpBody");
  }
  /**
   * Retrieves all the resources in the patient compartment for a `Patient`
   * resource.
   *
   * Implements the FHIR extended operation [Patient-
   * everything](http://hl7.org/implement/standards/fhir/STU3/patient-
   * operations.html#everything).
   *
   * On success, the response body will contain a JSON-encoded representation of a
   * `Bundle` resource of type `searchset`, containing the results of the
   * operation. Errors generated by the FHIR store will contain a JSON-encoded
   * `OperationOutcome` resource describing the reason for the error. If the
   * request cannot be mapped to a valid API method on a FHIR store, a generic GCP
   * error might be returned instead. (fhir.PatientEverything)
   *
   * @param string $name Name of the `Patient` resource for which the information
   * is required.
   * @param array $optParams Optional parameters.
   *
   * @opt_param string end The response includes records prior to the end date. If
   * no end date is provided, all records subsequent to the start date are in
   * scope.
   * @opt_param string start The response includes records subsequent to the start
   * date. If no start date is provided, all records prior to the end date are in
   * scope.
   * @return Google_Service_CloudHealthcare_HttpBody
   */
  public function PatientEverything($name, $optParams = array())
  {
    $params = array('name' => $name);
    $params = array_merge($params, $optParams);
    return $this->call('Patient-everything', array($params), "Google_Service_CloudHealthcare_HttpBody");
  }
  /**
   * Deletes all the historical versions of a resource (excluding the current
   * version) from the FHIR store. To remove all versions of a resource, first
   * delete the current version and then call this method.
   *
   * This is not a FHIR standard operation. (fhir.ResourcePurge)
   *
   * @param string $name The name of the resource to purge.
   * @param array $optParams Optional parameters.
   * @return Google_Service_CloudHealthcare_HealthcareEmpty
   */
  public function ResourcePurge($name, $optParams = array())
  {
    $params = array('name' => $name);
    $params = array_merge($params, $optParams);
    return $this->call('Resource-purge', array($params), "Google_Service_CloudHealthcare_HealthcareEmpty");
  }
  /**
   * Gets the FHIR [capability statement](http://hl7.org/implement/standards/fhir/
   * STU3/capabilitystatement.html) for the store, which contains a description of
   * functionality supported by the server.
   *
   * Implements the FHIR standard [capabilities interaction](http://hl7.org/implem
   * ent/standards/fhir/STU3/http.html#capabilities).
   *
   * On success, the response body will contain a JSON-encoded representation of a
   * `CapabilityStatement` resource. (fhir.capabilities)
   *
   * @param string $name Name of the FHIR store to retrieve the capabilities for.
   * @param array $optParams Optional parameters.
   * @return Google_Service_CloudHealthcare_HttpBody
   */
  public function capabilities($name, $optParams = array())
  {
    $params = array('name' => $name);
    $params = array_merge($params, $optParams);
    return $this->call('capabilities', array($params), "Google_Service_CloudHealthcare_HttpBody");
  }
  /**
   * Deletes FHIR resources that match a search query.
   *
   * Implements the FHIR standard [conditional delete interaction](http://hl7.org/
   * implement/standards/fhir/STU3/http.html#2.21.0.13.1). If multiple resources
   * match, all of them will be deleted.
   *
   * Search terms are provided as query parameters following the same pattern as
   * the search method.
   *
   * Note: Unless resource versioning is disabled by setting the
   * disable_resource_versioning flag on the FHIR store, the deleted resources
   * will be moved to a history repository that can still be retrieved through
   * vread and related methods, unless they are removed by the purge method.
   * (fhir.conditionalDelete)
   *
   * @param string $parent The name of the FHIR store this resource belongs to.
   * @param string $type The FHIR resource type to delete, such as Patient or
   * Observation. For a complete list, see the [FHIR Resource
   * Index](http://hl7.org/implement/standards/fhir/STU3/resourcelist.html).
   * @param array $optParams Optional parameters.
   * @return Google_Service_CloudHealthcare_HealthcareEmpty
   */
  public function conditionalDelete($parent, $type, $optParams = array())
  {
    $params = array('parent' => $parent, 'type' => $type);
    $params = array_merge($params, $optParams);
    return $this->call('conditionalDelete', array($params), "Google_Service_CloudHealthcare_HealthcareEmpty");
  }
  /**
   * If a resource is found based on the search criteria specified in the query
   * parameters, updates part of that resource by applying the operations
   * specified in a [JSON Patch](http://jsonpatch.com/) document.
   *
   * Implements the FHIR standard [conditional patch
   * interaction](http://hl7.org/implement/standards/fhir/STU3/http.html#patch).
   *
   * Search terms are provided as query parameters following the same pattern as
   * the search method.
   *
   * If the search criteria identify more than one match, the request will return
   * a `412 Precondition Failed` error.
   *
   * The request body must contain a JSON Patch document, and the request headers
   * must contain `Content-Type: application/json-patch+json`.
   *
   * On success, the response body will contain a JSON-encoded representation of
   * the updated resource, including the server-assigned version ID. Errors
   * generated by the FHIR store will contain a JSON-encoded `OperationOutcome`
   * resource describing the reason for the error. If the request cannot be mapped
   * to a valid API method on a FHIR store, a generic GCP error might be returned
   * instead. (fhir.conditionalPatch)
   *
   * @param string $parent The name of the FHIR store this resource belongs to.
   * @param string $type The FHIR resource type to update, such as Patient or
   * Observation. For a complete list, see the [FHIR Resource
   * Index](http://hl7.org/implement/standards/fhir/STU3/resourcelist.html).
   * @param Google_Service_CloudHealthcare_HttpBody $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_CloudHealthcare_HttpBody
   */
  public function conditionalPatch($parent, $type, Google_Service_CloudHealthcare_HttpBody $postBody, $optParams = array())
  {
    $params = array('parent' => $parent, 'type' => $type, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('conditionalPatch', array($params), "Google_Service_CloudHealthcare_HttpBody");
  }
  /**
   * If a resource is found based on the search criteria specified in the query
   * parameters, updates the entire contents of that resource.
   *
   * Implements the FHIR standard [conditional update
   * interaction](http://hl7.org/implement/standards/fhir/STU3/http.html#cond-
   * update).
   *
   * Search terms are provided as query parameters following the same pattern as
   * the search method.
   *
   * If the search criteria identify more than one match, the request will return
   * a `412 Precondition Failed` error. If the search criteria identify zero
   * matches, and the supplied resource body contains an `id`, and the FHIR store
   * has enable_update_create set, creates the resource with the client-specified
   * ID. If the search criteria identify zero matches, and the supplied resource
   * body does not contain an `id`, the resource will be created with a server-
   * assigned ID as per the create method.
   *
   * The request body must contain a JSON-encoded FHIR resource, and the request
   * headers must contain `Content-Type: application/fhir+json`.
   *
   * On success, the response body will contain a JSON-encoded representation of
   * the updated resource, including the server-assigned version ID. Errors
   * generated by the FHIR store will contain a JSON-encoded `OperationOutcome`
   * resource describing the reason for the error. If the request cannot be mapped
   * to a valid API method on a FHIR store, a generic GCP error might be returned
   * instead. (fhir.conditionalUpdate)
   *
   * @param string $parent The name of the FHIR store this resource belongs to.
   * @param string $type The FHIR resource type to update, such as Patient or
   * Observation. For a complete list, see the [FHIR Resource
   * Index](http://hl7.org/implement/standards/fhir/STU3/resourcelist.html). Must
   * match the resource type in the provided content.
   * @param Google_Service_CloudHealthcare_HttpBody $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_CloudHealthcare_HttpBody
   */
  public function conditionalUpdate($parent, $type, Google_Service_CloudHealthcare_HttpBody $postBody, $optParams = array())
  {
    $params = array('parent' => $parent, 'type' => $type, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('conditionalUpdate', array($params), "Google_Service_CloudHealthcare_HttpBody");
  }
  /**
   * Creates a FHIR resource.
   *
   * Implements the FHIR standard [create
   * interaction](http://hl7.org/implement/standards/fhir/STU3/http.html#create),
   * which creates a new resource with a server-assigned resource ID.
   *
   * Also supports the FHIR standard [conditional create
   * interaction](http://hl7.org/implement/standards/fhir/STU3/http.html#ccreate),
   * specified by supplying an `If-None-Exist` header containing a FHIR search
   * query. If no resources match this search query, the server processes the
   * create operation as normal.
   *
   * The request body must contain a JSON-encoded FHIR resource, and the request
   * headers must contain `Content-Type: application/fhir+json`.
   *
   * On success, the response body will contain a JSON-encoded representation of
   * the resource as it was created on the server, including the server-assigned
   * resource ID and version ID. Errors generated by the FHIR store will contain a
   * JSON-encoded `OperationOutcome` resource describing the reason for the error.
   * If the request cannot be mapped to a valid API method on a FHIR store, a
   * generic GCP error might be returned instead. (fhir.create)
   *
   * @param string $parent The name of the FHIR store this resource belongs to.
   * @param string $type The FHIR resource type to create, such as Patient or
   * Observation. For a complete list, see the [FHIR Resource
   * Index](http://hl7.org/implement/standards/fhir/STU3/resourcelist.html). Must
   * match the resource type in the provided content.
   * @param Google_Service_CloudHealthcare_HttpBody $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_CloudHealthcare_HttpBody
   */
  public function create($parent, $type, Google_Service_CloudHealthcare_HttpBody $postBody, $optParams = array())
  {
    $params = array('parent' => $parent, 'type' => $type, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('create', array($params), "Google_Service_CloudHealthcare_HttpBody");
  }
  /**
   * Deletes a FHIR resource.
   *
   * Implements the FHIR standard [delete
   * interaction](http://hl7.org/implement/standards/fhir/STU3/http.html#delete).
   *
   * Note: Unless resource versioning is disabled by setting the
   * disable_resource_versioning flag on the FHIR store, the deleted resources
   * will be moved to a history repository that can still be retrieved through
   * vread and related methods, unless they are removed by the purge method.
   * (fhir.delete)
   *
   * @param string $name The name of the resource to delete.
   * @param array $optParams Optional parameters.
   * @return Google_Service_CloudHealthcare_HttpBody
   */
  public function delete($name, $optParams = array())
  {
    $params = array('name' => $name);
    $params = array_merge($params, $optParams);
    return $this->call('delete', array($params), "Google_Service_CloudHealthcare_HttpBody");
  }
  /**
   * Executes all the requests in the given Bundle.
   *
   * Implements the FHIR standard [batch/transaction interaction](http://hl7.org/i
   * mplement/standards/fhir/STU3/http.html#transaction).
   *
   * Supports all interactions within a bundle, except search. This method accepts
   * Bundles of type `batch` and `transaction`, processing them according to the
   * [batch processing
   * rules](http://hl7.org/implement/standards/fhir/STU3/http.html#2.21.0.17.1)
   * and [transaction processing
   * rules](http://hl7.org/implement/standards/fhir/STU3/http.html#2.21.0.17.2).
   *
   * The request body must contain a JSON-encoded FHIR `Bundle` resource, and the
   * request headers must contain `Content-Type: application/fhir+json`.
   *
   * For a batch bundle or a successful transaction the response body will contain
   * a JSON-encoded representation of a `Bundle` resource of type `batch-response`
   * or `transaction-response` containing one entry for each entry in the request,
   * with the outcome of processing the entry. In the case of an error for a
   * transaction bundle, the response body will contain a JSON-encoded
   * `OperationOutcome` resource describing the reason for the error. If the
   * request cannot be mapped to a valid API method on a FHIR store, a generic GCP
   * error might be returned instead. (fhir.executeBundle)
   *
   * @param string $parent Name of the FHIR store in which this bundle will be
   * executed.
   * @param Google_Service_CloudHealthcare_HttpBody $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_CloudHealthcare_HttpBody
   */
  public function executeBundle($parent, Google_Service_CloudHealthcare_HttpBody $postBody, $optParams = array())
  {
    $params = array('parent' => $parent, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('executeBundle', array($params), "Google_Service_CloudHealthcare_HttpBody");
  }
  /**
   * Lists all the versions of a resource (including the current version and
   * deleted versions) from the FHIR store.
   *
   * Implements the per-resource form of the FHIR standard [history
   * interaction](http://hl7.org/implement/standards/fhir/STU3/http.html#history).
   *
   * On success, the response body will contain a JSON-encoded representation of a
   * `Bundle` resource of type `history`, containing the version history sorted
   * from most recent to oldest versions. Errors generated by the FHIR store will
   * contain a JSON-encoded `OperationOutcome` resource describing the reason for
   * the error. If the request cannot be mapped to a valid API method on a FHIR
   * store, a generic GCP error might be returned instead. (fhir.history)
   *
   * @param string $name The name of the resource to retrieve.
   * @param array $optParams Optional parameters.
   *
   * @opt_param int count The maximum number of search results on a page. Defaults
   * to 1000.
   * @opt_param string since Only include resource versions that were created at
   * or after the given instant in time. The instant in time uses the format YYYY-
   * MM-DDThh:mm:ss.sss+zz:zz (for example 2015-02-07T13:28:17.239+02:00 or
   * 2017-01-01T00:00:00Z). The time must be specified to the second and include a
   * time zone.
   * @opt_param string page Used to retrieve the first, previous, next, or last
   * page of resource versions when using pagination. Value should be set to the
   * value of the `link.url` field returned in the response to the previous
   * request, where `link.relation` is "first", "previous", "next" or "last".
   *
   * Omit `page` if no previous request has been made.
   * @opt_param string at Only include resource versions that were current at some
   * point during the time period specified in the date time value. The date
   * parameter format is yyyy-mm-ddThh:mm:ss[Z|(+|-)hh:mm]
   *
   * Clients may specify any of the following:
   *
   * *  An entire year: `_at=2019` *  An entire month: `_at=2019-01` *  A specific
   * day: `_at=2019-01-20` *  A specific second: `_at=2018-12-31T23:59:58Z`
   * @return Google_Service_CloudHealthcare_HttpBody
   */
  public function history($name, $optParams = array())
  {
    $params = array('name' => $name);
    $params = array_merge($params, $optParams);
    return $this->call('history', array($params), "Google_Service_CloudHealthcare_HttpBody");
  }
  /**
   * Updates part of an existing resource by applying the operations specified in
   * a [JSON Patch](http://jsonpatch.com/) document.
   *
   * Implements the FHIR standard [patch
   * interaction](http://hl7.org/implement/standards/fhir/STU3/http.html#patch).
   *
   * The request body must contain a JSON Patch document, and the request headers
   * must contain `Content-Type: application/json-patch+json`.
   *
   * On success, the response body will contain a JSON-encoded representation of
   * the updated resource, including the server-assigned version ID. Errors
   * generated by the FHIR store will contain a JSON-encoded `OperationOutcome`
   * resource describing the reason for the error. If the request cannot be mapped
   * to a valid API method on a FHIR store, a generic GCP error might be returned
   * instead. (fhir.patch)
   *
   * @param string $name The name of the resource to update.
   * @param Google_Service_CloudHealthcare_HttpBody $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_CloudHealthcare_HttpBody
   */
  public function patch($name, Google_Service_CloudHealthcare_HttpBody $postBody, $optParams = array())
  {
    $params = array('name' => $name, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('patch', array($params), "Google_Service_CloudHealthcare_HttpBody");
  }
  /**
   * Gets the contents of a FHIR resource.
   *
   * Implements the FHIR standard [read
   * interaction](http://hl7.org/implement/standards/fhir/STU3/http.html#read).
   *
   * Also supports the FHIR standard [conditional read
   * interaction](http://hl7.org/implement/standards/fhir/STU3/http.html#cread)
   * specified by supplying an `If-Modified-Since` header with a date/time value
   * or an `If-None-Match` header with an ETag value.
   *
   * On success, the response body will contain a JSON-encoded representation of
   * the resource. Errors generated by the FHIR store will contain a JSON-encoded
   * `OperationOutcome` resource describing the reason for the error. If the
   * request cannot be mapped to a valid API method on a FHIR store, a generic GCP
   * error might be returned instead. (fhir.read)
   *
   * @param string $name The name of the resource to retrieve.
   * @param array $optParams Optional parameters.
   * @return Google_Service_CloudHealthcare_HttpBody
   */
  public function read($name, $optParams = array())
  {
    $params = array('name' => $name);
    $params = array_merge($params, $optParams);
    return $this->call('read', array($params), "Google_Service_CloudHealthcare_HttpBody");
  }
  /**
   * Searches for resources in the given FHIR store according to criteria
   * specified as query parameters.
   *
   * Implements the FHIR standard [search
   * interaction](http://hl7.org/implement/standards/fhir/STU3/http.html#search)
   * using the search semantics described in the [FHIR Search
   * specification](http://hl7.org/implement/standards/fhir/STU3/search.html).
   *
   * Supports three methods of search defined by the specification:
   *
   * *  `GET [base]?[parameters]` to search across all resources. *  `GET
   * [base]/[type]?[parameters]` to search resources of a specified type. *  `POST
   * [base]/[type]/_search?[parameters]` as an alternate form having the same
   * semantics as the `GET` method.
   *
   * The `GET` methods do not support compartment searches. The `POST` method does
   * not support `application/x-www-form-urlencoded` search parameters.
   *
   * On success, the response body will contain a JSON-encoded representation of a
   * `Bundle` resource of type `searchset`, containing the results of the search.
   * Errors generated by the FHIR store will contain a JSON-encoded
   * `OperationOutcome` resource describing the reason for the error. If the
   * request cannot be mapped to a valid API method on a FHIR store, a generic GCP
   * error might be returned instead.
   *
   * The server's capability statement, retrieved through capabilities, indicates
   * what search parameters are supported on each FHIR resource. A list of all
   * search parameters defined by the specification can be found in the [FHIR
   * Search Parameter Registry](http://hl7.org/implement/standards/fhir/STU3
   * /searchparameter-registry.html).
   *
   * Supported search modifiers: `:missing`, `:exact`, `:contains`, `:text`,
   * `:in`, `:not-in`, `:above`, `:below`, `:[type]`, `:not`, and `:recurse`.
   *
   * Supported search result parameters: `_sort`, `_count`, `_include`,
   * `_revinclude`, `_summary=text`, `_summary=data`, and `_elements`.
   *
   * The maximum number of search results returned defaults to 100, which can be
   * overridden by the `_count` parameter up to a maximum limit of 1000. If there
   * are additional results, the returned `Bundle` will contain pagination links.
   * (fhir.search)
   *
   * @param string $parent Name of the FHIR store to retrieve resources from.
   * @param Google_Service_CloudHealthcare_SearchResourcesRequest $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_CloudHealthcare_HttpBody
   */
  public function search($parent, Google_Service_CloudHealthcare_SearchResourcesRequest $postBody, $optParams = array())
  {
    $params = array('parent' => $parent, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('search', array($params), "Google_Service_CloudHealthcare_HttpBody");
  }
  /**
   * Updates the entire contents of a resource.
   *
   * Implements the FHIR standard [update
   * interaction](http://hl7.org/implement/standards/fhir/STU3/http.html#update).
   *
   * If the specified resource does not exist and the FHIR store has
   * enable_update_create set, creates the resource with the client-specified ID.
   *
   * The request body must contain a JSON-encoded FHIR resource, and the request
   * headers must contain `Content-Type: application/fhir+json`. The resource must
   * contain an `id` element having an identical value to the ID in the REST path
   * of the request.
   *
   * On success, the response body will contain a JSON-encoded representation of
   * the updated resource, including the server-assigned version ID. Errors
   * generated by the FHIR store will contain a JSON-encoded `OperationOutcome`
   * resource describing the reason for the error. If the request cannot be mapped
   * to a valid API method on a FHIR store, a generic GCP error might be returned
   * instead. (fhir.update)
   *
   * @param string $name The name of the resource to update.
   * @param Google_Service_CloudHealthcare_HttpBody $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_CloudHealthcare_HttpBody
   */
  public function update($name, Google_Service_CloudHealthcare_HttpBody $postBody, $optParams = array())
  {
    $params = array('name' => $name, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('update', array($params), "Google_Service_CloudHealthcare_HttpBody");
  }
  /**
   * Gets the contents of a version (current or historical) of a FHIR resource by
   * version ID.
   *
   * Implements the FHIR standard [vread
   * interaction](http://hl7.org/implement/standards/fhir/STU3/http.html#vread).
   *
   * On success, the response body will contain a JSON-encoded representation of
   * the resource. Errors generated by the FHIR store will contain a JSON-encoded
   * `OperationOutcome` resource describing the reason for the error. If the
   * request cannot be mapped to a valid API method on a FHIR store, a generic GCP
   * error might be returned instead. (fhir.vread)
   *
   * @param string $name The name of the resource version to retrieve.
   * @param array $optParams Optional parameters.
   * @return Google_Service_CloudHealthcare_HttpBody
   */
  public function vread($name, $optParams = array())
  {
    $params = array('name' => $name);
    $params = array_merge($params, $optParams);
    return $this->call('vread', array($params), "Google_Service_CloudHealthcare_HttpBody");
  }
}
